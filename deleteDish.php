<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

$result = mysqli_query($con, "DELETE FROM menu_item where dishID = " . $_GET["did"]);

header("Location: restInfo.php?rid=" . $_GET["rid"]);
?>
