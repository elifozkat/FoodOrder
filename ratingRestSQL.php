<?php

$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	session_start();
	$result = mysqli_query($con, "INSERT INTO rate_rest (username, restID, ranking, comment) VALUES ('" . $_SESSION["username"] . "','" . $_POST["restID"] . "','" . $_POST["ranking"] . "','" . $_POST["comment"] . "')");
    
    if ($result === TRUE) {
	
        header("Location: rateRests.php");
	
    } else {
		echo "You already rated this dish";
         //header("Location: registrationform.php");
    }


mysqli_close($con);

?>
