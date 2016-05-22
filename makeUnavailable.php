<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

$result = mysqli_query($con, "UPDATE menu_item SET is_available = 'N' where dishID = " . $_GET["did"]);
$result = mysqli_query($con, "DELETE FROM has_in_cart where dishID = " . $_GET["did"]);
$result = mysqli_query($con, "DELETE FROM orders where is_completed = 'N' AND dishID = " . $_GET["did"]);


header("Location: restInfo.php?rid=" . $_GET["rid"]);
?>
