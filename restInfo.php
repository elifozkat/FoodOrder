<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

// open-close
$result = mysqli_query($con, "SELECT open_hour, close_hour, city_name FROM restaurant WHERE restID='" . $_GET["rid"] . "'");
$row = mysqli_fetch_array($result);
$open_h = $row[0];
$close_h = $row[1];
$city = $row[2];

$avgDelTime = array();
$result = mysqli_query($con, "SELECT district_name, avg_delivery_time FROM serves WHERE restID='" . $_GET["rid"] . "'");
while ($row = mysqli_fetch_array($result))
{
    $avgDelTime[$row[0]] = $row[1];
}

$result = mysqli_query($con, "SELECT district_name FROM district WHERE city_name = '" . $city . "'");
echo "<form action='saveDistricts.php' method='post'>";
echo "Choose the districts that your restaurant serves.<br><br>";
echo "<input type='hidden' name='rid' value='" . $_GET["rid"] . "'<br>";
while ($row = mysqli_fetch_array($result))
{
    if($avgDelTime[$row[0]]){
        echo "<input type='checkbox' name='" . $row[0] . "' value='" . $row[0] . "' checked>" . $row[0];
        echo " - Avg. Delivery Time:";
        echo  "<input type='number' name='" . $row[0] . "_delTime' min='0' max='120' step='5' value='" . $avgDelTime[$row[0]] ."'>";
    }
    else{
        echo "<input type='checkbox' name='" . $row[0] . "' value='" . $row[0] . "'>" . $row[0];
        echo " - Avg. Delivery Time:";
        $a = $row[0] . "_delTime";
        echo  "<input type='number' name='" . $row[0] . "_delTime' min='0' max='120' step='5' value=''>";
    }
    
    echo "<br>";    
}
echo "<input type='submit' value='Save Changes'>";
echo "</form>";

// Display Dishes
$result = mysqli_query($con, "select dishID, dish_name as 'Dish Name', dish_price as 'Price', dish_type as 'Dish Type', is_available from menu_item where restID = " . $_GET["rid"]);
print_dishes($result);
echo "<br><br><td><a href='addDishForm.php?rid=" . $_GET["rid"] . "'>Add Dish</a></td><br><br>";


// Display incomplete orders
$result = mysqli_query($con, "SELECT orderID, username, 
       order_datetime AS 'Order Date', 
       delivery_datetime AS 'Delivery Date', 
       ptype AS 'Payment', 
       total_cost AS 'Total'
       FROM   orders 
       WHERE  restID = " . $_GET["rid"] . "
       AND is_completed = 'N'");
   
echo "There are " . $result->num_rows . " waiting order(s).<br>";

if($result->num_rows > 0)
{
    print_result($result);
}

// HELPER - Prints the resulting table of an SQL command
function print_result($result)
{
	echo "<table border='1'>";
	echo "<tr>";
    for ($i = 1; $i < mysqli_num_fields($result); $i++) {
		echo "<th>";
		$finfo = mysqli_fetch_field_direct($result , $i);
		echo $finfo->name;
		echo "</th>";
		}
	echo "</tr>";   

	while ($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		for ($i = 1; $i < mysqli_num_fields($result); $i++) {
			echo "<td>" . $row[$i] . "</td>";
            if($i == mysqli_num_fields($result) - 1){
                echo "<td><a href='markComplete.php?oid=" . $row[0] . "&rid=" . $_GET["rid"] . "'>Mark Complete</a></td>";
            }
		}
		echo "</tr>";
		}
	echo "</table>";
}

// HELPER - Prints the resulting table of an SQL command
function print_dishes($result)
{
	echo "<table border='1'>";
	echo "<tr>";
    for ($i = 1; $i < mysqli_num_fields($result) - 1; $i++) {
		echo "<th>";
		$finfo = mysqli_fetch_field_direct($result , $i);
		echo $finfo->name;
		echo "</th>";
		}
	echo "</tr>";   

	while ($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		for ($i = 1; $i < mysqli_num_fields($result) - 1; $i++) {
			echo "<td>" . $row[$i] . "</td>";
            if($i == mysqli_num_fields($result) - 2){
				if($row[mysqli_num_fields($result) - 1] == 'N'){
                echo "<td><a href='makeAvailable.php?did=" . $row[0] . "&rid=" . $_GET["rid"] . "'>Make Available</a></td>";
			}else{
			echo "<td><a href='makeUnavailable.php?did=" . $row[0] . "&rid=" . $_GET["rid"] . "'>Make Unavailable</a></td>";
			}
			echo "<td><a href='deleteDish.php?did=" . $row[0] . "&rid=" . $_GET["rid"] . "'>Delete</a></td>";
            }
		}
		echo "</tr>";
		}
	echo "</table>";
}
?>
