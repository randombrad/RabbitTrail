<?php
	session_start();
	
	$_SESSION['polyline'] = $_REQUEST['polyline'];
	$_SESSION['distance'] = $_REQUEST['distance'];
	
?>