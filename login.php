
<?php
$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_POST["username"]) && isset($_POST["password"])){
	
$result = mysqli_query($con, "SELECT username, name, surname FROM customer WHERE username='" . $_POST["username"] ."' and password='" . $_POST["password"] . "'");

if($row=mysqli_fetch_array($result)){

session_start();

$_SESSION["username"]=$row[0];
$_SESSION["firstName"]=$row[1];
$_SESSION["lastName"]=$row[2];
$_SESSION["type"]="customer";
header("Location: index.php");
}else{
	$result=mysqli_query($con, "SELECT username, name, surname FROM rest_owner WHERE username='" . $_POST["username"] ."' and password='" . $_POST["password"] . "'");
	
	if($row=mysqli_fetch_array($result)){
	
		session_start();
		$_SESSION["username"]=$row[0];
		$_SESSION["firstName"]=$row[1];
		$_SESSION["lastName"]=$row[2];
		$_SESSION["type"]="restowner";
		header("Location: index.php");
	}else{
		
		header("Location: login.html");
		
	}
}
}


mysqli_close($con);
?>

