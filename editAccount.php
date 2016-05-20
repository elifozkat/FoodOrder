<html>
	<body>
		<?php
		$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
session_start();
if($_SESSION["type"]=="customer"){
$result= mysqli_query($con, "SELECT * FROM customer WHERE username='" . $_SESSION["username"]."'");
if($row=mysqli_fetch_array($result)){
	$_SESSION["username"]=$row[0];
	$_SESSION["firstName"]=$row[2];
	$_SESSION["lastName"]=$row[3];
	$_SESSION["phoneNumber"]=$row[4];
	$_SESSION["doorNo"]=$row[5];
	$_SESSION["street"]=$row[6];
	$_SESSION["districtName"]=$row[7];
	$_SESSION["cityName"]=$row[8];
	$city_district= $_SESSION["cityName"]. " - " .$_SESSION["districtName"];
}
}else if($_SESSION["type"]=="restowner"){
	$result= mysqli_query($con, "SELECT * FROM rest_owner WHERE username='" . $_SESSION["username"] ."'");
if($row=mysqli_fetch_array($result)){
	$_SESSION["username"]=$row[0];
	$_SESSION["firstName"]=$row[2];
	$_SESSION["lastName"]=$row[3];
	$_SESSION["phoneNumber"]=$row[4];
	$_SESSION["doorNo"]=$row[5];
	$_SESSION["street"]=$row[6];
	$_SESSION["districtName"]=$row[7];
	$_SESSION["cityName"]=$row[8];
	$city_district= $_SESSION["cityName"] . " - " . $_SESSION["districtName"];
}
}
mysqli_close($con);
		?>
	
<form id='editAccount' action='updateAccount.php' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>You can change and update your info by filling the form </legend>
	<input type='hidden' name='submitted' id='submitted' value='1'/>

	<label for='name' >Name: </label>
	<input type='text' name='name' value="<?php echo $_SESSION["firstName"];?>" required maxlength="25" /><br><br>

	
	<label for='surname' >Surname: </label>
	<input type='text' name='surname' value="<?php echo $_SESSION["lastName"];?>" required maxlength="25" /><br><br>

 
	<label for='username' >Username:</label>
	<input type='text' name='username' value="<?php echo $_SESSION["username"];?>" disabled /><br><br>
 
	<label for='password' >Password:</label>
	<input type='password' name='password' placeholder='Password' pattern=".{6,}" required title="6 characters minimum" maxlength="20" /><br><br>
	
	
	<label for='phonenum' >Phone Number:</label>
	<input type='number' name='phonenum' value="<?php echo $_SESSION["phoneNumber"];?>" pattern=".{10,}"required title="Please enter at least 10 digit phone number!" maxlength="13"/><br><br>
		<fieldset >
			<legend>Address Info</legend>
	
		<label for='city_district_name' > City and District Name: </label>
	
	<select name="city_district_name" required> 
	<option value="<?php echo $city_district;?>"><?php echo $city_district;?></option>  
	
<?php 
$con = mysqli_connect("servername", "username", "password", "dbname");
 
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 
 $result = mysqli_query($con, "SELECT * FROM district order by city_name, district_name");


 while ($row = mysqli_fetch_array($result)){
	 if($city_district != $row[1]." - ".$row[0]){
	 
	 ?><option value="<?php echo $row[1]." - ".$row[0];?>"><?php echo $row[1]." - ".$row[0];?></option>
	  
	 <?php
}

 }
 mysqli_close($con);
 
 
 ?>
 
 
 </select><br><br> 
	
	<label for='street' >Street:</label>
	<input type='text' name='street' value="<?php echo $_SESSION["street"];?>" required maxlength="30" /><br><br>
	
	<label for='door_no' > Door No: </label>
	<input type='text' name='doorno' value="<?php echo $_SESSION["doorNo"];?>" required maxlength="5" /><br><br>

	</fieldset>

  
	<input type='submit' name='Submit' value='Submit' /> 
 
</fieldset>
</form>

</body>
</html>
