<?php
//will get route id from GET
//needs to return all of the data in a string.

	include("connect.php");
	$routeId = $_REQUEST['rId'];
		
	$query="SELECT * FROM Routes WHERE RouteId='$routeId'";
	$result = mysql_db_query('rabbitadmin', $query);
	
	$row = mysql_fetch_array($result);
	$mypolyline = $row['polyline'];
	

	echo $mypolyline;
?>