<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");
$result = mysqli_query($con, "DELETE FROM has_in_cart WHERE username='" . $_SESSION["username"] . "'");
$_SESSION["cartSize"] = 0;
$_SESSION["cart"] = array();
unset($_SESSION["cartRestID"]);
header("Location: index.php");
?>