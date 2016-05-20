<?php

$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if(ctype_alpha(substr($_POST["password"], 0, 1))){
	session_start();
	$str = $_POST["city_district_name"];
	$city=substr($str, 0, strpos($str, " - "));
	$district=substr($str, strpos($str, " - ")+3, 20);
   
	$result = mysqli_query($con, "UPDATE customer SET password='". $_POST["password"] ."', name='". $_POST["name"] ."', surname='". $_POST["surname"] ."', phone_number='". $_POST["phonenum"] ."', door_no='". $_POST["doorno"] ."', street='". $_POST["street"] ."', district_name='". $district ."', city_name='". $city ."', type='', bonus_points='' WHERE username='". $_SESSION["username"] ."'");
    if (mysqli_affected_rows($con) > 0) {
		
		$_SESSION["firstName"]=$_POST["name"];
		$_SESSION["lastName"]=$_POST["surname"];
		$_SESSION["type"]="customer";
        header("Location: editAccount.php");
	
    }
  
     else{
	
		$result = mysqli_query($con, "UPDATE rest_owner SET password='". $_POST["password"] ."', name='". $_POST["name"] ."', surname='". $_POST["surname"] ."', phone_number='". $_POST["phonenum"] ."', door_no='". $_POST["doorno"] ."', street='". $_POST["street"] ."', district_name='". $district ."', city_name='". $city ."', type='' WHERE username='". $_SESSION["username"] ."'");
		if(mysqli_affected_rows($con) > 0){
		
		$_SESSION["firstName"]=$_POST["name"];
		$_SESSION["lastName"]=$_POST["surname"];
		$_SESSION["type"]="restowner";
        header("Location: editAccount.php");
      } 
    }
}else{
	echo "<script>
alert('Your password should start with an alphabetic character!');
window.location.href='editAccount.php';
</script>";
}


mysqli_close($con);

?>
