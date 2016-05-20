<html>
	<body>
		<?php
		$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
session_start();
if($_SESSION["type"]=="customer"){
	
$result= mysqli_query($con, "SELECT distinct rID.restID, rest_name as 'Restaurant'
  from restaurant inner join (select orderID, restID
  from orders
  where username='". $_SESSION["username"] ."') as rID on restaurant.restID=rID.restID");

	$numfields = mysqli_num_fields($result);
    
    echo "<table border='1'> <tr>";
    
    for ($i = 0; $i < $numfields; $i++) {
        $fieldinf = mysqli_fetch_field_direct($result, $i);
        if($fieldinf->name != "restID"){
        echo "<th>" . $fieldinf->name . "</th>";
	}
        if($i==$numfields-1){
			echo "<th>Rank and Comment for the Restaurant</th>";
			
		}
	
    }
    
    echo "</tr>";
    
    while ($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		
		for($i=0; $i < $numfields; $i++){
			if($i!=0){
			
        echo "<td>".$row[$i]."</td>"; 
	}
	
        if($i==$numfields-1){
			$result2=mysqli_query($con, "SELECT * FROM rate_rest WHERE username='". $_SESSION["username"] ."' and restID='". $row[0] ."'");
			$row2 = mysqli_fetch_array($result2);
			$result3=mysqli_query($con, "SELECT restID, delivery_datetime FROM orders
  WHERE username='". $_SESSION["username"] ."' and DATE_ADD(delivery_datetime, INTERVAL 2 WEEK) >= CURDATE()");
			$row3 = mysqli_fetch_array($result3);
			
			if($result2->num_rows==0 && $row3[0]==$row[0]){
			?> 
			<form id='rateMeals' action='ratingRestSQL.php' method='post' accept-charset='UTF-8'>
				<input type='hidden' name='restID' id='restID' value='<?php echo $row[0];?>'/>
			<td>Ranking:<input type="range" name="ranking" min="0" max="5"><br>
			Comment:<textarea name="comment" placeholder="Leave a Comment" rows="3" cols="15"></textarea>
			<input type="submit" name='go' value="Go!"></td>
			</form>
  
  <?php
		}else{
			?>
			
			<td>Ranking:<input type="range" name="ranking" value="<?php echo $row2[2];?>" min="0" max="5" disabled><br>
			Comment:<textarea name="comment" placeholder="<?php echo $row2[3];?>" rows="3" cols="15" disabled></textarea>
			<input type="submit" name='go' value="Go!" disabled></td>
			</form>
			<?php
		}
	}
}


	echo "</tr>";
	
    }
    
    echo "</table>";

}else{
	echo "Impossible Error";
}
 mysqli_close($con);
 
 
 ?>
 

</body>
</html>
