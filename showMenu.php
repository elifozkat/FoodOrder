<?php
session_start();
echo "Menu of " . $_GET["n"] . "<br><br>";
$con = mysqli_connect("servername", "username", "password", "dbname");

// Display cart size
        $result = mysqli_query($con, "SELECT Count(*) 
                FROM   has_in_cart 
                WHERE  username = '" . $_SESSION["username"] . "'");
        $row = mysqli_fetch_array($result);
        echo "You have " . $row[0] . " item(s) in your <a href='cart.php'>cart</a><br><br>";

// Display restaurants
$result = mysqli_query($con, "SELECT dishID, dish_name  AS 'Dish Name', 
       dish_price AS 'Price', 
       dish_type  AS 'Dish Type' 
       FROM   menu_item 
       WHERE  is_available = 'Y' AND restID = " . $_GET["r"]);
        if($result->num_rows > 0)
        {
            print_menu($result);
        }
        else
        {
            echo "No dishes are available at this time.";
        }
$result = mysqli_query($con, "select dish_name from (select dishID, sum(quantity), restID from includes inner join orders on orders.orderID = includes.orderID where restID = " . $_GET["r"] . " group by dishID order by sum(quantity) desc limit 3) as a inner join menu_item on menu_item.dishID = a.dishID");
        if($result->num_rows > 0)
        {
            echo "<br><br>";
            echo "Top dishes<br><br>";
            print_result($result);
        }
mysqli_close($con);

// HELPER - Prints the resulting table of an SQL command
function print_menu($result)
{
	echo "<table border='1'>";
	echo "<tr>";
    for ($i = 1; $i < mysqli_num_fields($result); $i++) {
		echo "<th>";
		$finfo = mysqli_fetch_field_direct($result , $i);
		echo $finfo->name;
		echo "</th>";
		}
    echo "<th>";
    echo "</th>";
	echo "</tr>";   

	while ($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		for ($i = 1; $i < mysqli_num_fields($result); $i++) {
			echo "<td>" . $row[$i] . "</td>";
            if($i === $result->field_count - 1){
                echo "<td><a href='addCart.php?d=" . $row[0] . "&r=" . $_GET["r"] . "&n=" . $_GET["n"]. "'>" . "Add to Cart</a></td>";
            }
		}
		echo "</tr>";
		}
	echo "</table>";
}

// Prints the resulting table of an SQL command
function print_result($result)
	{
	echo "<table border='1'>";
	echo "<tr>";
    for ($i = 0; $i < mysqli_num_fields($result); $i++) {
		echo "<th>";
		$finfo = mysqli_fetch_field_direct($result , $i);
		echo $finfo->name;
		echo "</th>";
		}
	echo "</tr>";   

	while ($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		for ($i = 0; $i < mysqli_num_fields($result); $i++) {
			echo "<td>" . $row[$i] . "</td>";
		}
		echo "</tr>";
		}
	echo "</table>";
	}
?>
