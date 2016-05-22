<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");


$result = mysqli_query($con, "SELECT city_name FROM restaurant WHERE restID=" . $_POST["rid"]);
$row = mysqli_fetch_array($result);
$city = $row[0];
$todo = array();

$result = mysqli_query($con, "DELETE FROM serves WHERE restID = " . $_POST["rid"]);

$result = mysqli_query($con, "SELECT district_name FROM district WHERE city_name='" . $city . "'");
while ($row = mysqli_fetch_array($result))
{
    if(isset($_POST[$row[0]])){
        
        //$todo[] =  $row[0];
        /*$result2 = mysqli_query($con, "DELETE FROM serves WHERE district_name='" . $_POST[$row[0]] . "' AND restID = " . $_POST["rid"]);*/
        
        $result2 = mysqli_query($con, "INSERT INTO serves (restID, district_name, avg_delivery_time) VALUES (" . $_POST["rid"] . ", '" . $_POST[$row[0]] . "', " . $_POST[$row[0] . "_delTime"] . ")");

    }/*else{
        echo $row[0];
        $result = mysqli_query($con, "DELETE FROM serves WHERE district_name='" . $_POST[$row[0]] . "' AND restID = " . $_POST["rid"]);
    }*/
}

header("Location: restInfo.php?rid=" . $_POST["rid"]);
?>