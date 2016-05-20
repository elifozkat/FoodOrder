
<?php
session_start();
$con = mysqli_connect("servername", "username", "password", "dbname");

$a="N";

 if(isset($_POST["is_available"])){s
	 
	 $a="Y";
 }

$result = mysqli_query($con, "INSERT INTO menu_item (restID, dish_name, dish_price, dish_type, is_available) VALUES(" . $_POST["rid"] .", '". $_POST["dishName"] ."', '". $_POST["dishPrice"] ."', '". $_POST["dishType"] ."', '" . $a ."')");


header("Location: restInfo.php?rid=" . $_POST["rid"]);
?>
