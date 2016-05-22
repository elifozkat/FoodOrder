<?php
session_start();

$con = mysqli_connect("servername", "username", "password", "dbname");
$result = mysqli_query($con, "select ID, rest_name AS 'Restaurant Name', cuisine   AS 'Cuisine', avg_delivery_time as 'Average Delivery Time' from (SELECT ids.restID as ID, 
       rest_name, 
       cuisine
FROM   restaurant AS r, 
       ((SELECT restID 
         FROM   (SELECT restID, 
                        serves.district_name, 
                        city_name 
                 FROM   serves INNER JOIN district 
                                        ON serves.district_name = 
                                           district.district_name) AS j 
                 WHERE  j.district_name = (SELECT district_name 
                                           FROM   customer 
                                           WHERE  username = '" . $_SESSION["username"] . "')) 
                UNION 
                (SELECT restid 
                 FROM   restaurant AS r 
                 WHERE  r.city_name = (SELECT city_name 
                                       FROM   customer 
                                       WHERE  username = '" . $_SESSION["username"] . "') 
                        AND NOT EXISTS(SELECT * 
                                       FROM   serves 
                                       WHERE  restid = r.restid))) AS ids 
        WHERE  ids.restid = r.restid 
               AND ( 
                    r.open_hour <= Curtime() OR Curtime() <= r.close_hour    
                    )) AS complex 
       INNER JOIN serves 
               ON complex.id = serves.restid 
WHERE  district_name = (SELECT district_name 
                        FROM   customer 
                        WHERE  username = '" . $_SESSION["username"] . "') 
ORDER  BY avg_delivery_time ASC 
    ");
echo "There are " . $result->num_rows . " available restaurants at this time.";
if($result->num_rows > 0)
        {
            print_restaurants($result);
        }

// Prints the resulting table of an SQL command
function print_restaurants($result)
{
	echo "<table border='1'>";
	echo "<tr>";
    for ($i = 1; $i < mysqli_num_fields($result); $i++) {
		echo "<th>";
		$finfo = mysqli_fetch_field_direct($result , $i);
		echo $finfo->name;
		echo "</th>";
		}
	echo "</tr>";   

	while ($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		for ($i = 1; $i < mysqli_num_fields($result); $i++) {
            if($i == 1){
			echo "<td><a href='showMenu.php?r=" . $row[0] . "&n=" . $row[$i] . "'>" . $row[$i] . "</a></td>";
            }
            else{
                
			echo "<td>" . $row[$i] . "</td>";
            }
		}
		echo "</tr>";
		}
	echo "</table>";
}
mysqli_close($con);
?>