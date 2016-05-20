<?php

$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	session_start();
	$result = mysqli_query($con, "INSERT INTO rate_dish (username, dishID, ranking, comment) VALUES ('" . $_SESSION["username"] . "','" . $_POST["dishID"] . "','" . $_POST["ranking"] . "','" . $_POST["comment"] . "')");
    
    if ($result === TRUE) {
	
        header("Location: rateMeals.php");
	
    } else {
		echo "You already rated this dish";
         //header("Location: registrationform.php");
    }


mysqli_close($con);

?>
