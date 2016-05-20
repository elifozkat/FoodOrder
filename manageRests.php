<html>
	<body>
		<?php
		$con = mysqli_connect("servername", "username", "password", "dbname");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
session_start();

	$result= mysqli_query($con, "SELECT restID, rest_name as 'Restaurant Name', cuisine as 'Cuisine', city_name as 'City Name', open_hour as 'Open Hour', close_hour as 'Close Hour', username FROM restaurant WHERE username='" . $_SESSION["username"] ."'");
		
	$numfields = mysqli_num_fields($result);
    
    echo "<table border='1'> <tr>";
    
    for ($i = 0; $i < $numfields; $i++) {
        $fieldinf = mysqli_fetch_field_direct($result, $i);
        if($fieldinf->name != "restID" && $fieldinf->name != "username"){
        
        echo "<th>" . $fieldinf->name . "</th>";
	}
    }
    
    echo "</tr>";
    
    while ($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		
		for($i=0; $i < $numfields; $i++){
		if($i != 0 && $i !=6){
			if($i==1){
        echo "<td><a href='restInfo.php?rid=".$row[0]."'>".$row[$i]."</a></td>"; 
	}else{
		echo "<td>".$row[$i]."</td>";
		}
	}
        if($i==$numfields-1){
			
			echo "<td><a href='deleteRest.php?rid=". $row[0] ."'>Delete</a></td>";
		}
	
}


	echo "</tr>";
	
    }
    
    echo "</table>";
    echo "<br><br><td><a href='addRestForm.php'>Add a New Restaurant</a></td>";


mysqli_close($con);
		?>
	
