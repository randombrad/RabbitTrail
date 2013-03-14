<?php
/******   CREATED BY    ********/
/******   BRAD WOOD     ********/
/******  KYLIE NELSON   ********/
/****** PHIL VanderMeer ********/
/******     MAY 2007    ********/

	
//This Grabs the User Id for the user that is currently Logged in	
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

//Gets UserName from any Id that is passed
function getUserName($id){
	$sql="SELECT UserId, UserName FROM `UserLog` WHERE `UserId` = '$id'";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	while($row=mysql_fetch_array($result)){
		$id=$row[1]; 
			
		}
		return $id;
}


function getUserPic($id){
	$sql="SELECT `pic` FROM `UserData` WHERE `UserId` = '$id'";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	while($row=mysql_fetch_array($result)){
		$pic=$row['pic']; 
			
		}
	return $pic;
}


/******     DELETE A ROUTE********/	
if(isset($_GET['action']) && $_GET['action']=="delete"){	
	if (isset($_GET['id'])){
		$q="DELETE FROM `Routes` WHERE `RouteId` = ".$_GET['id']."";
	    mysql_query($q)
		or die(mysql_error());  
	
		echo "Data Inserted!";
	   	   
	   /* Quick self-redirect to avoid resending data on refresh */
	   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=map&action=view\">";
	}
} // END of ISSET ACTION IS DELETE	


/******  END OF DELETE Route    ********/	

?>
<table align = "center">
<tr width="100%">
	<td><a href="?cmd=map&action=create">| CREATE A ROUTE</a></td>
	<td><a href="?cmd=map&action=view">| VIEW YOUR ROUTES</a></td>
	<td><a href="?cmd=map&action=see">| VIEW ALL ROUTES |</a></td></tr>
	<tr><td><br/></td></tr>
</table>

<?php

/******     EDIT ROUTE INFO  ********/	
if(isset($_GET['action']) && $_GET['action']=="edit"){	//VIEW ALL OF THE USER'S Routes print (getUserId())
	if (isset($_GET['id'])){
		$id2=getUserId();
		$sql="SELECT * FROM `Routes` WHERE  `RouteId` = ".$_GET['id']." AND `OUserId` = '$id2'";
		$result=mysql_query($sql);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		while($row=mysql_fetch_array($result)){
?>
			<table align = "center" >
				<tr width = "100%"><td><h3>Edit Route Information</h3></td></tr>	
					<form action="index.php?cmd=map&action=edit" method="post">
						<table align="left" cellspacing="0" cellpadding="3" >
							<tr ><input type="hidden" name="user" value="<?php print (getUserId())?>"></td></tr>
							<tr ><input type="hidden" name="routeid" value="<?php echo $_GET['id'];?>"></td></tr>
							
							<tr><td>City:</td><td><input type="text" name="city" value="
							
							<?php echo "$row[City]"; ?>"></td></tr>
							
							<tr><td>State:</td><td><input type="text" name="state" value="
							
							<?php echo "$row[State]"; ?>"></td></tr>
							
							<tr><td>Zip:</td><td><input type="text" name="zip" value="
							
							<?php echo "$row[Zip]"; ?>"></td></tr>
							
							<tr>
								<td>Type:</td>
									<td width="200px" colspan="2">
									<fieldset id="RouteType\" border="0">
											<select name="type">
												<option><?php echo "$row[Type]";?></option>";
												<option>Road</option>";
												<option>Trail</option>";
												<option>Sidewalk</option>";
												<option>Other</option>";
											</select>
									</fieldset>
									</td>
								</tr>
							
							
							
							<tr><td>Info:</td><td><textarea name="info" cols=30 rows=2><?php echo "$row[Info]"; ?></textarea>
							</td></tr>
							
							
							<input type="hidden" name="editroute" value="1">
		<tr><td colspan="2" align="right"><input type="submit" name="sublog" value="Edit Route"></td></tr>
	</form></table>
	<?php
	}
	}
	}/******     END OF ISSET $id    ********/
	
	
/******    Show Map  ********/	
if(isset($_GET['action']) && $_GET['action']=="showmap"){
	
	$routeId = $_GET['id'];
	
?>
		<html>
			<head> 
			<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAVEGhP97Xn-Jev5czlKZsBxRT8El_-6A6_yjzMm131f3YY80vEhTm6JzYeCo0BNRg58FdCAGYwp6xZQ" type="text/javascript"></script>
			<script type="text/javascript" src="map.js"></script>
			</head>
		<body onLoad = drawMap("<?php echo $routeId; ?>")>

		<p><div id="div_map" style="width: 430px; height: 300px"></div></p>		
		<table align = "center">
			<tr width="100%">
				<?php
				if(isset($_GET['log']) && ($_GET['log'] == 'view')){
					echo "<td><a href = '?cmd=log&action=view'>|RETURN TO YOUR LOGS|</a></td></tr>";
				}else if(isset($_GET['log']) && ($_GET['log'] == 'all')){
					echo "<td><a href = '?cmd=log&action=see'>|RETURN TO ALL LOGS|</a></td></tr>";
				}else{
					echo "<td><a href = '?cmd=map&action=view'>|RETURN TO YOUR ROUTES|</a></td></tr>";
				}?>
				<tr><td><br/></td></tr>
		</table>
		
		</body>
		</html>
	<?php
		include_once("connect.php");
		$userid = getUserId();
		$sql="SELECT * FROM `RunningLog` WHERE UserId = '$userid' AND RouteId = $routeId";
		$result=mysql_query($sql);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if(mysql_num_rows($result)){
			include "charts.php";
			echo InsertChart ( "charts.swf", "charts_library", "sample.php?rId=$routeId", 430, 260 );
		}
	
	}

	
	
if(isset($_POST['editroute'])){
   $city=$_POST['city'];
   $state=$_POST['state'];
   $zip=$_POST['zip'];
   $info=$_POST['info'];
   $type=$_POST['type'];

   $id=$_POST['routeid'];
   
   mysql_query("UPDATE `Routes` SET `City` = '$city', `State` = '$state',`Zip` = ".$zip.", `Type` = '$type', `Info` = '$info' WHERE `RouteId` = ".$id." ")
   or die(mysql_error());  

echo "Data Inserted!";
   
   
   /* Quick self-redirect to avoid resending data on refresh */
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=map&action=view\">";
  // return;
}

//VIEW ALL OF THE USER'S LOGS print (getUserId())
if(isset($_GET['action']) && $_GET['action']=="view"){	
	
		$id=getUserId();
		$sql=" SELECT * FROM `Routes` WHERE `OUserId` = '$id'";
		$result=mysql_query($sql);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		
		 
		echo "<table width=\"400px\">\n";
		
				$num_rows = mysql_num_rows($result);
				if (!$num_rows){
				echo "<tr width=\"100%\" align=\"center\" >
				<td >You Havn't Created Any Routes!</td>\n";
				
				}else{
				echo "<tr width=\"100%\"  >
				<td></td>\n
				<td>City</td>\n
				<td>State</td>\n
				<td>Zip</td>\n
				<td>Type</td>
				<td>Info</td>
				<td>Distance</td></tr>\n";
				
				}
			while($row=mysql_fetch_array($result)){
				echo "<tr><td><a href=\"?cmd=log&action=create&rId=$row[0]&distance=$row[Distance]\" title = 'Create a log with this route'><img src=\"./images/add.gif\"/></a></td>";
				echo "<td bgcolor=\"#362E2B\">$row[City]</td>"; 
				echo "<td bgcolor=\"#362E2B\">$row[State]</td>"; 
				echo "<td bgcolor=\"#362E2B\">$row[Zip]</td>"; 
				echo "<td bgcolor=\"#362E2B\">$row[Type]</td>";
				echo "<td bgcolor=\"#362E2B\">$row[Info]</td>";
				echo "<td bgcolor=\"#362E2B\">";
				printf("%.2f", $row['Distance']);
				echo "</td>";
				echo "<td bgcolor=\"#362E2B\"><a href=\"?cmd=map&action=showmap&id=$row[0]\">Map</a></td>";
				echo "<td bgcolor=\"#362E2B\"><a href=\"?cmd=map&action=edit&id=$row[0]\"><img src=\"./images/edit.png\"/></a></td>";
				echo "<td bgcolor=\"#362E2B\"><a href=\"?cmd=map&action=delete&id=$row[0]\"><img src=\"./images/delete.png\"/></a></td></tr>";
				
				
				
			}
		echo "</table>\n";
		
	}	
//VIEW ALL LOGS
if(isset($_GET['action']) && $_GET['action']=="see"){	
	$id=getUserId();
	$sql=" SELECT * FROM `Routes` ORDER BY `RouteId` DESC";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	
	echo "<table width=\"400px\">\n";
	echo "<tr width=\"100%\"  >
			<td> </td>\n
			<td>User</td>\n
			<td>City</td>\n
			<td>State</td>\n
			<td>Zip</td>\n
			<td>Type</td>\n
			<td>Info</td>\n
			<td>Distance</td></tr>\n";
			
		while($row=mysql_fetch_array($result)){
		$picture=getUserPic($row['OUserId']);
			echo "<tr><td><a href=\"?cmd=log&action=create&rId=$row[0]&distance=$row[Distance]\" title = 'Create a log with this route'><img src=\"./images/add.gif\"/></a></td>";
			echo "<td bgcolor=\"#362E2B\" align='center'>"; print (getUserName($row['OUserId'])); echo "<br /><img src='.$picture' width='40px'></a></td>"; 
			echo "<td bgcolor=\"#362E2B\">$row[City]</td>"; 
			echo "<td bgcolor=\"#362E2B\">$row[State]</td>"; 
			echo "<td bgcolor=\"#362E2B\">$row[Zip]</td>"; 
			echo "<td bgcolor=\"#362E2B\">$row[Type]</td>";
			echo "<td bgcolor=\"#362E2B\">$row[Info]</td>";
			echo "<td bgcolor=\"#362E2B\">";
				printf("%.2f", $row['Distance']);
			echo "</td>"; 
			echo "<td bgcolor=\"#362E2B\"><a href=\"?cmd=map&action=showmap&id=$row[0]\">Map</a></td></tr>";			
		}
	echo "</table>\n";
}	


//Create a route
if(isset($_GET['action']) && $_GET['action']=="create"){	
?>
<html>
	<head> 
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAVEGhP97Xn-Jev5czlKZsBxRT8El_-6A6_yjzMm131f3YY80vEhTm6JzYeCo0BNRg58FdCAGYwp6xZQ" type="text/javascript"></script>
		<script type="text/javascript" src="map2.js"></script>
		</head>
	<body >
		<p>Enter the address to center the map on:</p>
		<form action="#" onsubmit="showAddress(this.address.value); return false">
			<p>
				<input type="text" size="50" name="address" value="236 West Reade Ave, Upland, IN" > <input type="submit" value="Go!" />
			</p>
		</form>
		<p>
		<div id="div_map" style="width: 430px; height: 300px"></div>
		</p>
		<table align = "center">
			<tr width="100%">
				<td><a href = "" onClick = "return clickedFinish()">|Finish Route</a></td>
				<td><a href = "" onClick = "return clickedClear()">|Clear Route|</a></td></tr>
				<tr><td><br/></td></tr>
		</table>

	
		
		
		
	<table width="100%" ><tr><td><h3>Create Route Information</h3></td></tr>	
			<form action="index.php?cmd=map" method="post">
				<table align="left" cellspacing="0" cellpadding="3" >
						<tr ><input type="hidden" name="user" value="<?php print (getUserId())?>"></td></tr>
							<tr><td>City:</td><td><input type="text" name="city"></td></tr>
							
							<tr><td>State:</td><td><input type="text" name="state"></td></tr>
							
							<tr><td>Zip:</td><td><input type="text" name="zip"></td></tr>
							
							<tr>
								<td>Type:</td>
									<td width="200px" colspan="2">
									<fieldset id="RouteType\" border="0">
											<select name="type">
												<option></option>";
												<option>Road</option>";
												<option>Trail</option>";
												<option>Sidewalk</option>";
												<option>Other</option>";
											</select>
									</fieldset>
									</td></tr>
							
							
							<tr><td>Info :</td><td><textarea name="info" cols=30 rows=2></textarea></td></tr></td></tr>
							
							<input type="hidden" name="insertroute" value="1">
						<tr><td colspan="2" align="right"><input type="submit" name="subroute" onClick = "clickedSave()" value="Create Route"></td></tr>
						</table>
								</form></table>
</body>
</html>
<?php 

} // close the if set for the create log

if(isset($_POST['insertroute'])){
   $id=getUserId();
   $city=$_POST['city'];
   $state=$_POST['state'];
   $zip=$_POST['zip'];
   $type=$_POST['type'];
   $info=$_POST['info'];
   $distance = $_SESSION['distance'];
   $polyline = $_SESSION['polyline'];
   
   $q="INSERT INTO `Routes` (`OUserId` ,`City` ,`State` ,`Zip` ,`Type`, `Info`, `Distance` ,`polyline`)VALUES ('$id' , '$city', '$state', '.$zip.', '$type', '$info', '$distance', '$polyline')";
  
   mysql_query($q)
   or die(mysql_error());  

echo "Data Inserted!";
   
   
   /* Quick self-redirect to avoid resending data on refresh */
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=map&action=view\">";
  // return;
}


?>
