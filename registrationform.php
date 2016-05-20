<html>
	<body>
<form id='register' action='registration.php' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>Please fill the places marked with (*) </legend>
	<input type='hidden' name='submitted' id='submitted' value='1'/>

	<label for='name' >Name (*): </label>
	<input type='text' name='name' placeholder='Your Name' required maxlength="25" /><br><br>
	<label for='surname' >Surname (*): </label>
	<input type='text' name='surname' placeholder='Your Last Name' required maxlength="25" /><br><br>

 
	<label for='username' >Username (*):</label>
	<input type='text' name='username' placeholder='Username' required maxlength="20" /><br><br>
 
	<label for='password' >Password (*):</label>
	<input type='password' name='password' placeholder='Password' pattern=".{6,}" required title="6 characters minimum" maxlength="20" /><br><br>
	
	<label for='phonenum' >Phone Number (*):</label>
	<input type='number' name='phonenum' placeholder='Phone Number' pattern=".{10,}"required title="Please enter at least 10 digit phone number!" maxlength="13"/><br><br>
		<fieldset >
			<legend>Address (*)</legend>
	
	<label for='city_district_name' > City and District Name: </label>
	
	<select name="city_district_name" required> 
<option value="select">Select City and District </option>  
	
<?php 
$con = mysqli_connect("servername", "username", "password", "dbname");
 
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 
 $result = mysqli_query($con, "SELECT * FROM district order by city_name, district_name");


 while ($row = mysqli_fetch_array($result)){
	 
	 ?><option value="<?php echo $row[1]." - ".$row[0];?>"><?php echo $row[1]." - ".$row[0];?></option>
	  
	 <?php


 }
 mysqli_close($con);
 
 
 ?>
 
 
 </select><br><br> 

		
	<label for='street' >Street:</label>
	<input type='text' name='street' placeholder='Street Name' required maxlength="30" /><br><br>
	
	<label for='door_no' > Door No: </label>
	<input type='number' name='doorno' placeholder='Door Number' required min="1" max="99999"/><br><br>

	</fieldset>
  <input type="radio" name="type" value="customer" checked> Customer<br>
  <input type="radio" name="type" value="restowner"> Restaurant Owner<br><br>
  
	<input type='submit' name='Submit' value='Submit' />
 
</fieldset>
</form>

</body>
</html>
