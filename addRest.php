<?php

$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	session_start();
	$result=mysqli_query($con, "INSERT INTO restaurant (rest_name, cuisine, city_name, open_hour, close_hour, username) VALUES ('". $_POST["restName"] ."','". $_POST["cuisine"] ."','". $_POST["cityName"] ."','". $_POST["openHour"] ."','". $_POST["closeHour"] ."','". $_SESSION["username"] ."')");
	$rid = $con->insert_id;
	$result = mysqli_query($con, "INSERT INTO serves (restID, district_name, avg_delivery_time)
SELECT *
FROM (SELECT " . $rid .", district_name, 0 from district where city_name='" . $_POST["cityName"] . "') as F");

	
    if ($result === TRUE) {	
        header("Location: manageRests.php");
    } 

else{
	echo "<br>You cannot add this restaurant right now. There are uncompleted orders taken from this restaurant!<br>";
	echo "<a href='manageRests.php'>Go Back to Restaurants</a>";
}

mysqli_close($con);

?>
