<html>
	<body>
<form id='addDish' action='addDish.php' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>To add a new dish you must fill the form below </legend>
	<?php echo "<input type='hidden' name='rid' id='submitted' value='". $_GET["rid"] ."'/>"; ?>

	<label for='dishName' >Dish Name: </label>
	<input type='text' name='dishName' placeholder='Name of the Dish' required maxlength="30" /><br><br>
	
	<label for='dishPrice' >Price of the Dish:</label>
	<input type='number' name='dishPrice' placeholder='Dish Price' step="0.01" required maxlength="10"/><br><br>
	
	<label for='dishType' >Type of the Dish: </label>
	<input type='text' name='dishType' placeholder='Dish Type' required maxlength="10" /><br><br>
	
 <input type="checkbox" name="is_available" checked> Available to Serve<br>
 
  
	</fieldset>
 
  
	<br><br><input type='submit' name='create' value='Create' />
 

</form>

</body>
</html>

