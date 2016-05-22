<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

$result = mysqli_query($con, "UPDATE menu_item SET is_available = 'Y' where dishID = " . $_GET["did"]);
header("Location: restInfo.php?rid=" . $_GET["rid"]);
?>
