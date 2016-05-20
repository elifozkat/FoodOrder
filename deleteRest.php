<?php

$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$result=mysqli_query($con, "SELECT * FROM orders WHERE restID='". $_GET["rid"] ."' and is_completed='N'");

	if($result->num_rows==0){
	$result = mysqli_query($con, "DELETE FROM restaurant WHERE restID='". $_GET["rid"] ."'");
    
    if ($result === TRUE) {
		if(mysqli_affected_rows($con) > 0){
	
        header("Location: manageRests.php");
	}
    } 

}else{
	echo "<br>You cannot delete this restaurant right now. There are uncompleted orders taken from this restaurant!<br>";
	echo "<a href='manageRests.php'>Go Back to Restaurants</a>";
}

mysqli_close($con);

?>
