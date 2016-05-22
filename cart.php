<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

// Display Cart
$result = mysqli_query($con, "SELECT dish_name AS 'Dish Name', 
       Count(dish_name) AS Quantity, 
       Sum(dish_price)  AS Price 
       FROM   has_in_cart AS h 
       INNER JOIN menu_item AS m 
               ON h.dishID = m.dishID 
               WHERE  username = '" . $_SESSION["username"] . "' 
               GROUP  BY dish_name ");

if($result->num_rows > 0)
{
    $total = print_result($result);
    echo "<br>";
    
    echo '<form action="checkout.php" method=post>';
    // Display cost
    echo "Your order costs " . $total . "TL. Please select a payment type:";
    
    // Payment types
    $result = mysqli_query($con, "SELECT * 
        FROM   payment_type ");
    echo "<select name='ptype'>";
    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = mysqli_fetch_array($result);
        echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
    }
    echo "</select><br><br>";
    
    // Checkout
    echo "<input type='submit' value='Proceed to checkout'>";    
    echo "</form>";
    
    // Empty cart
    echo "<a href='emptyCart.php'>Empty my cart</a><br><br>";
}
else
{
     echo "Your cart is empty.<br><br>";
}

// HELPER - Prints the resulting table of an SQL command
function print_result($result)
{
    $total = 0;
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
            if($i == 2){
                $total = $total + $row[$i];
            }
			echo "<td>" . $row[$i] . "</td>";
		}
		echo "</tr>";
		}
	echo "</table>";
    return $total;
}
?>