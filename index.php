<?php
session_start();

// Known User Arrival
if (isset($_SESSION["username"]))
{
?>
    <!-- // Hello message -->
	Hello <?php echo ucfirst($_SESSION["firstName"]) . " " . ucfirst($_SESSION["lastName"])."!";?>

    <!-- // Logout link -->
	<a href='logout.php'>Log out</a>
	<br>

    <!-- // Edit Account link -->
	<a href='editAccount.php'>Edit account</a>
	<br>
    <br>
    
	<?php
    
    // Customer
	if ($_SESSION["type"] === "customer")
	{	
       $con = mysqli_connect("servername", "username", "password", "dbname");
        
        // Display cart size
        $result = mysqli_query($con, "SELECT Count(*) 
                FROM   has_in_cart 
                WHERE  username = '" . $_SESSION["username"] . "'");
        $row = mysqli_fetch_array($result);
        echo "You have " . $row[0] . " item(s) in your <a href='cart.php'>cart</a><br><br>";
        
        // Restaurants link
        echo "Are you hungry? <a href='chooseRest.php'>Place an order</a><br><br>";
        
        // Display recent orders
		echo "Recent Orders<br>";
		$result = mysqli_query($con, "SELECT rest_name AS Restaurant, 
            order_datetime AS 'Order Date', 
            ptype          AS 'Payment Type', 
            total_cost     AS 'Total Cost' 
            FROM   orders INNER JOIN restaurant ON orders.restID = restaurant.restID 
            WHERE  orders.username = '" . $_SESSION["username"] . "' AND
            now() <= DATE_ADD(order_datetime, INTERVAL 2 Week)
            ORDER BY order_datetime DESC
            LIMIT 5");
        if($result->num_rows > 0)
        {
            print_result($result);
        }
        else
        {
            echo "You have not placed any orders recently.";
        }
        
        echo "<br><a href='rateMeals.php'>Rate your meals</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        
        echo "<a href='rateRests.php'>Rate restaurants</a><br><br>";
        mysqli_close($con);
        ?>
		<?php
	}
 
    // Restaurant Owner
	elseif ($_SESSION["type"] === "restowner")
	{
		// Restaurants link
        echo "Check out your <a href='manageRests.php'>restaurants</a>!<br><br>";
	}
	?>
<?php
}

// Unknown User Arrival
else
{ ?>
	Food Order
	<br>
	<br>
	You can <a href="registrationform.php">sign up</a>. You can even <a href="login.html">login</a>!
<?php
}

// HELPER - Prints the resulting table of an SQL command
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

