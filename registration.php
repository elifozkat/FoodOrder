<?php

$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if(ctype_alpha(substr($_POST["password"], 0, 1))){
$result=mysqli_query($con, "(select * from customer where username='". $_POST["username"] ."')
  union
(select * from customer where username='". $_POST["username"] ."')");
if($result->num_rows==0){
if($_POST["type"]=="customer"){
	$str = $_POST["city_district_name"];
	$city=substr($str, 0, strpos($str, " - "));
	$district=substr($str, strpos($str, " - ")+3, 20);
	
    
	$result = mysqli_query($con, "INSERT INTO customer (username, password, name, surname, phone_number, door_no, street, district_name, city_name, type, bonus_points) VALUES ('" . $_POST["username"] . "','" . $_POST["password"] . "','" . $_POST["name"] . "','" . $_POST["surname"] . "'," . $_POST["phonenum"] .",'" . $_POST["doorno"] ."','" . $_POST["street"] ."','" . $district ."','" . $city ."','','')");
    
    if ($result === TRUE) {
		session_start();
		$_SESSION["username"]=$_POST["username"];
		$_SESSION["firstName"]=$_POST["name"];
		$_SESSION["lastName"]=$_POST["surname"];
		$_SESSION["type"]=$_POST["type"];
        header("Location: index.php");
	
    } else {
		
         header("Location: registrationform.php");
    }

}else if($_POST["type"]=="restowner"){
	$str = $_POST["city_district_name"];
	$city=substr($str, 0, strpos($str, " - "));
	$district=substr($str, strpos($str, " - ")+3, 20);
	$result = mysqli_query($con, "INSERT INTO rest_owner (username, password, name, surname, phone_number, door_no, street, district_name, city_name, type) VALUES ('" . $_POST["username"] . "','" . $_POST["password"] . "','" . $_POST["name"] . "','" . $_POST["surname"] . "'," . $_POST["phonenum"] .",'" . $_POST["doorno"] ."','" . $_POST["street"] ."','" . $district ."','" . $city ."','')");
	
	if ($result === TRUE) {
        session_start();
		$_SESSION["username"]=$_POST["username"];
		$_SESSION["firstName"]=$_POST["name"];
		$_SESSION["lastName"]=$_POST["surname"];
		$_SESSION["type"]=$_POST["type"];
        header("Location: index.php");
	
    } else {
        header("Location: registrationform.php");
    }
}
}else{
	echo "<script>
alert('This username is already taken!');
window.location.href='registrationform.php';
</script>";
	
}
}else{
	echo "<script>
alert('Your password should start with an alphabetic character!');
window.location.href='registrationform.php';
</script>";
}

mysqli_close($con);

?>
