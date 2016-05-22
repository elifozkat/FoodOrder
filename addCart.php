<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");
if(!isset($_SESSION["cartRestID"]) || $_SESSION["cartRestID"] != $_GET["r"]){
    $result = mysqli_query($con, "DELETE FROM has_in_cart WHERE username='" . $_SESSION["username"] . "'");
    $_SESSION["cartSize"] = 0;
    $_SESSION["cart"] = array();
    $_SESSION["cartRestID"] = $_GET["r"];
} 
$result = mysqli_query($con, "INSERT INTO has_in_cart (username,dishID) 
        VALUES ('" . $_SESSION["username"] . "','" . $_GET["d"] . "')");
if(mysqli_affected_rows($con) > 0)
{
    $cartArray = $_SESSION["cart"];
    $numel = $_SESSION["cartSize"];
    $cartArray[$numel] = $_GET["d"];
    $_SESSION["cartSize"] = numel + 1;
    $_SESSION["cart"] = $cartArray;
    header("Location: showMenu.php?r=" . $_GET["r"] . "&n=" . $_GET["n"]);
}
else
{
    echo "Dish could not be added.";
}        
mysqli_close($con);
?>