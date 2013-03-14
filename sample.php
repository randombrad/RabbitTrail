<?php
session_start();
include "charts.php";
//This Grabs the User Id for the user that is currently Logged in	
function convertTimeToSec($time){
    $_time = explode(":", $time);

    // Convert each time to seconds
    $timeSec = (($_time[0] * 3600) + ($_time[1] * 60) + ($_time[2]));
	return $timeSec;
}

function getUserId(){
	$user=$_SESSION['username'];
	$sql="SELECT UserId, UserName FROM `UserLog` WHERE `UserName` = '$user'";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	while($row=mysql_fetch_array($result)){
		$id=$row[0]; 
			
		}
	return $id;
}


if(isset($_GET['rId'])){
	$routeId = $_GET['rId'];

	//connect to the database
	include_once("connect.php");
	$userid = getUserId();
	$sql="SELECT * FROM `RunningLog` WHERE UserId = '$userid' AND RouteId = $routeId";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}

	//extract the data from the query result one row at a time

	$xY[0] = "";
	$userData[0] = "User Data";
	$stuff = 0;
	$i = 1;
	$x = 1;
	while($row = mysql_fetch_array($result)) {
		
		$time = convertTimeToSec($row['Time'])/60;
	   //populate the PHP array with the data
	   
		
			$xY[$i] = "x";
			$userData[$i] = $x;
			$xY[$i+1] = "y";
			$userData[$i+1] = $time;
	$i+=2;
	$x++;	
	}

	$chart[ 'chart_data' ] = array($xY, $userData);

	$chart['chart_grid_h'] = array ( 'alpha'=>10, 'color'=>000000, 'thickness'=>1 );
	$chart['chart_grid_v'] =  array ( 'alpha'=>20, 'color'=>000000, 'thickness'=>2, 'type'=>'dotted') ;
	$chart[ 'chart_pref' ] = array ( 'point_size'=>5, 'trend_alpha'=>20, 'trend_thickness'=>2 );

	$chart[ 'chart_rect' ] = array ( 'x'=> 50, 'y'=>50, 'width'=>330, 'height'=>150, 'positive_color'=>"000000",'positive_alpha'=>25, 'negative_color'=>"ff0000",  'negative_alpha'=>10 );
	$chart[ 'chart_type' ] = "scatter"; 
	$chart[ 'chart_value' ] = array ( 'position'=>"cursor", 'bold'=>true, 'size'=>12, 'color'=>"ffffff", 'alpha'=>75 );

	$chart[ 'draw' ] = array ( array ( 'type'=>"text", 'color'=>"ffffff", 'alpha'=>20, 'font'=>"arial", 'bold'=>true, 'size'=>20, 'x'=>60, 'y'=>220, 'width'=>430, 'height'=>75, 'text'=>"Times you've run this route", 'h_align'=>"left", 'v_align'=>"top" ),
	                           array ( 'type'=>"text", 'color'=>"ffffff", 'alpha'=>20, 'rotation'=>-90, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>225, 'width'=>200, 'height'=>60, 'text'=>"Time(Min)", 'h_align'=>"left", 'v_align'=>"bottom" ));

	$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"ffffff", 'alpha'=>50 ); 
	$chart[ 'legend_rect' ] = array ( 'x'=>50, 'y'=>30, 'width'=>10, 'height'=>10, 'margin'=>3, 'fill_color'=>"ffffff", 'fill_alpha'=>0, 'line_color'=>"000000", 'line_alpha'=>0, 'line_thickness'=>0 );  

	$chart[ 'series_color' ] = array ( "88ff00", "ff8800" );
}else{
	//connect to the database
	include_once("connect.php");
	$userid = getUserId();
	$sql="SELECT * FROM `RunningLog` WHERE UserId = '$userid'";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}

	//extract the data from the query result one row at a time

	$xY[0] = "";
	$userData[0] = "User Data";
	$stuff = 0;
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$distance = $row['Distance'];
		$time = convertTimeToSec($row['Time'])/60;
	   //populate the PHP array with the data
	   
		
			$xY[$i] = "x";
			$userData[$i] = $distance;
			$xY[$i+1] = "y";
			$userData[$i+1] = $time;
	$i+=2;	
	}

	$chart[ 'chart_data' ] = array($xY, $userData);
	


	$chart['chart_grid_h'] = array ( 'alpha'=>10, 'color'=>000000, 'thickness'=>1 );
	$chart['chart_grid_v'] =  array ( 'alpha'=>20, 'color'=>000000, 'thickness'=>2, 'type'=>'dotted') ;
	$chart[ 'chart_pref' ] = array ( 'point_size'=>5, 'trend_alpha'=>20, 'trend_thickness'=>2 );

	$chart[ 'chart_rect' ] = array ( 'x'=> 50, 'y'=>50, 'width'=>330, 'height'=>150, 'positive_color'=>"000000",'positive_alpha'=>25, 'negative_color'=>"ff0000",  'negative_alpha'=>10 );
	$chart[ 'chart_type' ] = "scatter"; 
	$chart[ 'chart_value' ] = array ( 'position'=>"cursor", 'bold'=>true, 'size'=>12, 'color'=>"ffffff", 'alpha'=>75 );

	$chart[ 'draw' ] = array ( array ( 'type'=>"text", 'color'=>"ffffff", 'alpha'=>20, 'font'=>"arial", 'bold'=>true, 'size'=>20, 'x'=>60, 'y'=>220, 'width'=>430, 'height'=>75, 'text'=>"Distance(Miles)", 'h_align'=>"left", 'v_align'=>"top" ),
	                           array ( 'type'=>"text", 'color'=>"ffffff", 'alpha'=>20, 'rotation'=>-90, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>225, 'width'=>200, 'height'=>60, 'text'=>"Time(Min)", 'h_align'=>"left", 'v_align'=>"bottom" ));

	$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"ffffff", 'alpha'=>50 ); 
	$chart[ 'legend_rect' ] = array ( 'x'=>50, 'y'=>30, 'width'=>10, 'height'=>10, 'margin'=>3, 'fill_color'=>"ffffff", 'fill_alpha'=>0, 'line_color'=>"000000", 'line_alpha'=>0, 'line_thickness'=>0 );  

	$chart[ 'series_color' ] = array ( "88ff00", "ff8800" );
}

SendChartData($chart);
	
?>