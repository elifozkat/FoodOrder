<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

$result = mysqli_query($con, "SELECT Sum(dish_price)  AS Price 
       FROM   has_in_cart AS h 
       INNER JOIN menu_item AS m 
               ON h.dishID = m.dishID 
               WHERE  username = '" . $_SESSION["username"] . "'");
$row = mysqli_fetch_array($result);
$total = $row[0];

$result = mysqli_query($con, "INSERT INTO orders (username, restID, order_datetime, ptype, is_completed, total_cost) VALUES ('" . $_SESSION["username"] . "'," . $_SESSION["cartRestID"] . ", now(),'" . $_POST["ptype"] . "','N'," . $total . ")");

$oid = $con->insert_id;

$result = mysqli_query($con, "INSERT INTO includes (orderID, dishID, quantity)
SELECT *
FROM (  SELECT " . $oid .", dishID, Count(dishID) from has_in_cart where username='" . $_SESSION["username"] . "' group by dishID) as F");



$result = mysqli_query($con, "DELETE FROM has_in_cart WHERE username='" . $_SESSION["username"] . "'");
    $_SESSION["cartSize"] = 0;
    $_SESSION["cart"] = array();
    unset($_SESSION["cartRestID"]);

header("Location: index.php");
?>
