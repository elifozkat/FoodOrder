<html>
	<body>
<form id='addRest' action='addRest.php' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>To add a new resturant please fill the necessary places</legend>
	<input type='hidden' name='submitted' id='submitted' value='1'/>

	<label for='restName' >Restaurant Name: </label>
	<input type='text' name='restName' placeholder="Name Your Restaurant" required maxlength="30" /><br><br>

	
	<label for='cuisine' >Cuisine: </label>
	<input type='text' name='cuisine' placeholder="Describe the Cuisine" maxlength="20" /><br><br>
	
	<label for='openHour' >Open Hour: </label>
	<input type='time' name='openHour' placeholder="Opening Hour" required /><br><br>
	
	<label for='closeHour' >Close Hour: </label>
	<input type='time' name='closeHour' placeholder="Closing Hour" required /><br><br>

 <label for='cityName' > City Name: </label>
	
	<select name="cityName" required> 
	<option value="select">Select a City</option>  
	
<?php 
$con = mysqli_connect("localhost","Group_18","fbixm","Group_18_db");
 
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 
 $result = mysqli_query($con, "SELECT * FROM city order by city_name");


 while ($row = mysqli_fetch_array($result)){
	 
	 
	 ?><option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
	  
	 <?php


 }
 mysqli_close($con);
 
 
 ?>
 
 
 </select><br><br> 
 
 <input type='submit' name='Create' value='Create This Restaurant!' /> 

</fieldset>
</form>

</body>
</html>
