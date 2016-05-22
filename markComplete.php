<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");
$result = mysqli_query($con, "UPDATE orders SET is_completed='Y', delivery_datetime = now() WHERE orderID = " . $_GET["oid"]);
header("Location: restInfo.php?rid=" . $_GET["rid"]);
?>