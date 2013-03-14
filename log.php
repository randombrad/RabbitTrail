<?
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


/******     DELETE RUNNER'S LOG    ********/	
if(isset($_GET['action']) && $_GET['action']=="delete"){	
	if (isset($_GET['id'])){
		$q="DELETE FROM `RunningLog` WHERE `LogId` = ".$_GET['id']."";
	    mysql_query($q)
		or die(mysql_error());  
	
		echo "Data Deleted!";
	   	   
	   /* Quick self-redirect to avoid resending data on refresh */
	   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=log&action=view\">";
	}
} // END of ISSET ACTION IS DELETE	


/******  END OF DELETE RUNNER'S LOG    ********/	

?>
<table align="center">
<tr width="300px">
	<td><a href="?cmd=log&action=create">| CREATE LOG </a></td>
	<td><a href="?cmd=log&action=view">| VIEW YOUR LOGS </a></td>
	<td><a href="?cmd=log&action=see">| VIEW ALL LOGS |</a></td></tr>
	<tr><td><br/></td></tr>
</table>

<?php

/******     EDIT RUNNER'S LOG    ********/	
if(isset($_GET['action']) && $_GET['action']=="edit"){	//VIEW ALL OF THE USER'S LOGS print (getUserId())
	if (isset($_GET['id'])){
		$id2=getUserId();
		$sql="SELECT * FROM `RunningLog` WHERE  `LogId` = ".$_GET['id']." AND `UserId` = '$id2'";
		$result=mysql_query($sql);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		while($row=mysql_fetch_array($result)){
?>
			<table width="100%" >
				<tr><td><h3>Edit Running Log</h3></td></tr>	
					<form action="index.php?cmd=log&action=edit" method="post">
						<table align="left" cellspacing="0" cellpadding="3" >
							<tr ><input type="hidden" name="user" value="<?php print (getUserId())?>"></td></tr>
							<tr ><input type="hidden" name="logid" value="<?php echo $_GET['id'];?>"></td></tr>
							
							<tr><td>Distance:</td><td><input type="text" name="dist" value="
							
							<?php echo "$row[5]"; $label2="miles"; if ($row[5]>1){$label2=" miles";}else{$label2=" mile";} ?>"><?php echo "$label2";?></td></tr>
							
							<tr>
								<td>Date Ran:</td><td>	
									<?php
										$_dran=explode(" ",$row[3]);
									$_ddate=explode("-",$_dran[0]);
									$_dtime=explode(":",$_dran[1]);
									?>
									<label for="date">Month   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
									<label for="date">Day</label>
									<label for="date">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year</label>
										<fieldset id="date\">
											<select name="month">
												<option><?php echo "$_ddate[1]"; ?></option>";
												<?php	
													for ($i=1; $i<=12;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> /
											<select name="day">
												<option><?php echo "$_ddate[2]"; ?></option>
												<?php
													for ($i=1; $i<=31;$i++){
														echo "<option>$i</option>";
													}
												?>	
											</select> /
											<select name="year">
												<option><?php echo "$_ddate[0]"; ?></option>
												<?php
													for ($i=2010; $i>1900;$i--){
														echo "<option>$i</option>";
													}
												?>
											</select> ex: 2/4/2007
										</fieldset>
									</td>
								</tr>
								<tr>
									<td>Time:</td>
									<td>												
										<label for="time">&nbsp;Hours   &nbsp;&nbsp;&nbsp; </label>
										<label for="time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mins</label>
													<label for="time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AM/PM</label>
											<fieldset id="time\">
												<select name="h">
													<?php 
														$hour=$_dtime[0];
													
														if ($hour>12){
															$hour=$hour-12;
															$pm=1;
														}
													?>
													<option><?php echo "$hour"; ?></option>";
													<?php	
														for ($i=0; $i<=12;$i++){
															echo "<option>$i</option>";
														} //H:i:s
													?>
												</select> :
												<select name="m">
													<option><?php echo "$_dtime[1]"; ?></option>
												<?php
													for ($i=0; $i<=59;$i++){
														echo "<option>$i</option>";
													}
												?>	
												</select>
												
												<select name="am">
													<?php  
													$hour=$_dtime[0];
													
														if ($hour<'12'){
															$hour=$hour-12;
															echo "<option>AM</option>";
														}else{
															echo "<option>PM</option>";
														}
													echo "<option>AM</option>";
													echo "<option>PM</option>";
													?>
												</select> ex: 5 : 37 PM
											</fieldset>
									</td>
								</tr>
								<tr>
									<td>Run Time:</td>
									<td>												
										<label for="rtime">&nbsp;Hours   &nbsp;&nbsp;&nbsp; </label>
										<label for="rtime">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mins</label>
													<label for="rtime">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sec</label>
											<fieldset id="rtime\">
												<select name="rh">
													<option><?php echo strftime ("%H", strtotime($row[4])); ?></option>";
													<?php	
														for ($i=0; $i<=12;$i++){
															echo "<option>$i</option>";
														} 
													?>
												</select> :
												<select name="rm">
													<option><?php echo strftime ("%M", strtotime($row[4])); ?></option>
													<?php
														for ($i=0; $i<=59;$i++){
															echo "<option>$i</option>";
														}
													?>	
												</select> :
												<select name="rs">
													<option><?php echo strftime ("%S", strtotime($row[4])); ?></option>
													<?php
														for ($i=0; $i<=59;$i++){
															echo "<option>$i</option>";
																												
														}
													?>	
												</select> ex: 5 : 23 : 9
											</fieldset>
									</td>
								</tr>
								<tr>
									<td>Body :</td>
									<td>
										<textarea name="body" cols=30 rows=6 ><?php echo "$row[6]";?></textarea>
									</td>
								</tr>
								
								
											<input type="hidden" name="editlog" value="1">
								<tr><td colspan="2" align="right"><input type="submit" name="sublog" value="Edit Log"></td></tr>
								</table>
										</form></table>
	<?php
	}
	}/******     END OF ISSET $id    ********/
if(isset($_POST['editlog'])){
   $userid=$_POST['user'];
   $dateyear=$_POST['year'];
   $datemonth=$_POST['month'];
   $dateday=$_POST['day'];
   $datehour=$_POST['h'];
   $datemin=$_POST['m'];
   $dateam=$_POST['am'];
   
   $runhour=$_POST['rh'];
   $runmin=$_POST['rm'];
   $runsec=$_POST['rs'];
   
   $distance=$_POST['dist'];
   $body=$_POST['body'];
  
  
  if ($dateam=="PM"){
		$datehour=$datehour+12;
  }
   //$datetime=$dateyear-$datemonth-$dateday $datehour:$datemin':00';
   $runningdate = date("y-m-d H:i:s",mktime($datehour,$datemin,00,$datemonth,$dateday,$dateyear));
   $runtime=date("H:i:s",mktime($runhour,$runmin,$runsec));
   echo "$runningdate   $runtime";
   $id=$_POST['logid'];
   //$q="UPDATE `RunningLog` SET `UserId` = ".$_POST['user'].",`RouteId` = '0',`Date` = '$runningdate',`Time` = '$runtime',`Distance` = ".$distance.", `Comments` = '$body' WHERE 'LogId` = ".12."";
    //SERT INTO `cos264s0707`.`RunningLog` (`LogId` ,`UserId` ,`RouteId` ,`Date` ,`Time` ,`Distance` ,`Comments`)VALUES ('NULL' , ".$_POST['user'].", '0', '$runningdate', '$runtime', ".$distance.", '$body')";
  //$q="INSERT INTO `cos264s0707`.`RunningLog` (`LogId` ,`UserId` ,`RouteId` ,`Date` ,`Time` ,`Distance` ,`Comments`)VALUES ('NULL' , ".$_POST['user'].", '0', '$runningdate', '$runtime', ".$distance.", '$body')";
  
   mysql_query("UPDATE `RunningLog` SET `UserId` = ".$_POST['user'].",`RouteId` = 0,`Date` = '$runningdate', `Time` = '$runtime',`Distance` = ".$distance.", `Comments` = '$body' WHERE `LogId` = ".$id." ")
   or die(mysql_error());  

echo "Data Inserted!";
   
   
   /* Quick self-redirect to avoid resending data on refresh */
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=log&action=view\">";
  // return;
}
}

if(isset($_GET['action']) && $_GET['action']=="view"){	//VIEW ALL OF THE USER'S LOGS print (getUserId())
	
		$id=getUserId();
		$sql=" SELECT * FROM `RunningLog` WHERE `UserId` = '$id'";
		$result=mysql_query($sql);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		
		 
		echo "<table width=\"400px\">\n";
		
				$num_rows = mysql_num_rows($result);
				if (!$num_rows){
				echo "<tr width=\"100%\" align=\"center\" >
				<td >You havn't Loged Any Activity!</td>\n";
				
				}else{
				echo "<tr width=\"100%\"  >
				<td>Map</td>\n
				<td>Date</td>\n
				<td>Running Time</td>\n
				<td>Distance</td></tr>\n";
				
				}
			while($row=mysql_fetch_array($result)){
				echo "<tr>"; 
				if($row['RouteId']){
					echo "<td bgcolor=\"#362E2B\"><a href=\"?cmd=map&action=showmap&id=$row[RouteId]&log=view\">Map</a></td>"; 
				}else{
					echo "<td bgcolor=\"#362E2B\">No Map</td>";
				}
				echo "<td bgcolor=\"#362E2B\">$row[3]</td>"; 
				echo "<td bgcolor=\"#362E2B\">$row[4]</td>"; 
				if ($row[5]>1){
				$label="miles";
				}else{
				$label="mile";
				}
				echo "<td bgcolor=\"#362E2B\">";
					printf("%.2f", $row['Distance']);
				echo " $label</td>";
				//echo "<td>$row[5] $label</td>";
				echo "<td><a href=\"?cmd=log&action=edit&id=$row[0]\"><img src=\"./images/edit.png\"/></a></td>";
				echo "<td><a href=\"?cmd=log&action=delete&id=$row[0]\"><img src=\"./images/delete.png\"/></a></td></tr>";
				
				echo "<tr><td colspan=\"7\">$row[6]</td></tr>"; 
				echo "<tr><td colspan=\"7\"><hr width=\"100%\"/></td></tr>"; 
				
				
			}
		echo "</table>\n";
		
	}	

if(isset($_GET['action']) && $_GET['action']=="see"){	//VIEW ALL LOGS
	$id=getUserId();
	$sql=" SELECT * FROM `RunningLog` ORDER BY `LogId` DESC";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	
	echo "<table width=\"400px\">\n";
	echo "<tr width=\"100%\"  >
			<td>User Name</td>\n
			<td>Map</td>\n
			<td>Date</td>\n
			<td>Running Time</td>\n
			<td>Distance</td></tr>\n";
		while($row=mysql_fetch_array($result)){
		$picture=getUserPic($row[1]);
		
			echo "<tr bgcolor=\"#362E2B\"><td align='center'>"; print (getUserName($row[1])); echo "<br /><img src='.$picture' width='40px'></a></td></td>"; 
	
				if($row['RouteId']){
					echo "<td align='center'><a href=\"?cmd=map&action=showmap&id=$row[RouteId]&log=all\">Map</a></td>"; 
				}else{
					echo "<td align='center'>No Map</td>";
				}
			
			echo "<td align='center'>$row[3]</td>"; 
			 
			echo "<td align='center'>$row[4]</td>"; 
			 
		
			if ($row[5]>1){
			$label="miles";
			}else{
			$label="mile";
			}
			echo "<td align='center'>";
				printf("%.2f", $row['Distance']);
			echo " $label</td>";
			//echo "<td>$row[5] $label</td></tr>"; 
			
			echo "<tr><td colspan=\"7\" align='center'>$row[6]</td></tr>"; 
			echo "<tr><td colspan=\"7\" align='center'><hr></td></tr>"; 
			
			
		}
	echo "</table>\n";
}	
if(isset($_GET['action']) && $_GET['action']=="create"){	
?>
	<table width="100%" ><tr><td><h3>Create Running Log <?php	
	if(isset($_GET['rId'])) {echo "With RouteID: $_GET[rId]"; $_SESSION['rId'] = $_GET['rId'];} ?></h3></td></tr>	
			<form action="index.php?cmd=log" method="post">
				<table align="left" cellspacing="0" cellpadding="3" >
						<tr ><input type="hidden" name="user" value="<?php print (getUserId())?>"></td></tr>
						<?php if(isset($_GET['distance'])){
							$_SESSION['distance'] = $_GET['distance'];
							}else{
							echo "<tr><td>Distance:</td><td><input type='text' name='dist'>  Miles</td></tr></td></tr>";
						}
						?>
						<tr><td>Date Ran:</td><td>												
													<label for="date">Month   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
													<label for="date">Day</label>
													<label for="date">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year</label>
													<fieldset id="date\">
														<select name="month">
															<option>--</option>";
													<?php	
														for ($i=1; $i<=12;$i++){
															echo "<option>$i</option>";
																										
														} 
													?>
														</select> /
														<select name="day">
															<option>--</option>
													<?php
														for ($i=1; $i<=31;$i++){
															echo "<option>$i</option>";
																										
														}
													?>	
														</select> /
														<select name="year">
															<option>--</option>
													<?php
														for ($i=2010; $i>1900;$i--){
															echo "<option>$i</option>";
														}
													?>
														</select> ex: 2/4/2007
													</fieldset>
													</td></tr>
						<tr><td>Time:</td><td>												
													<label for="time">&nbsp;Hours   &nbsp;&nbsp;&nbsp; </label>
													<label for="time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mins</label>
													<label for="time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AM/PM</label>
													<fieldset id="time\">
														<select name="h">
															<option>--</option>";
													<?php	
														for ($i=0; $i<=12;$i++){
															echo "<option>$i</option>";
																										
														} 
													?>
														</select> :
														<select name="m">
															<option>--</option>
													<?php
														for ($i=0; $i<=59;$i++){
															echo "<option>$i</option>";
																										
														}
													?>	
														</select>
														<select name="am">
															<option>--</option>
															<option>AM</option>
															<option>PM</option>
														</select> ex: 5 : 37 PM
													</fieldset>
													</td></tr>
						<tr><td>Run Time:</td><td>												
													<label for="rtime">&nbsp;Hours   &nbsp;&nbsp;&nbsp; </label>
													<label for="rtime">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mins</label>
													<label for="rtime">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sec</label>
													<fieldset id="rtime\">
														<select name="rh">
															<option>--</option>";
													<?php	
														for ($i=0; $i<=12;$i++){
															echo "<option>$i</option>";
																										
														} 
													?>
														</select> :
														<select name="rm">
															<option>--</option>
													<?php
														for ($i=0; $i<=59;$i++){
															echo "<option>$i</option>";
																										
														}
													?>	
														</select> :
														<select name="rs">
															<option>--</option>
															<?php
														for ($i=0; $i<=59;$i++){
															echo "<option>$i</option>";
																										
														}
													?>	
														</select> ex: 5 : 23 : 9
													</fieldset>
													</td></tr>
									<tr><td>Body :</td><td><textarea name="body" cols=30 rows=6></textarea></td></tr></td></tr>
									<input type="hidden" name="insertlog" value="1">
						<tr><td colspan="2" align="right"><input type="submit" name="sublog" value="Create Log"></td></tr>
						</table>
								</form></table>
<?php 

} // close the if set for the create log

if(isset($_POST['insertlog'])){
   $userid=$_POST['user'];
   $dateyear=$_POST['year'];
   $datemonth=$_POST['month'];
   $dateday=$_POST['day'];
   $datehour=$_POST['h'];
   $datemin=$_POST['m'];
   $dateam=$_POST['am'];
   
   $runhour=$_POST['rh'];
   $runmin=$_POST['rm'];
   $runsec=$_POST['rs'];
   
   
   $body=$_POST['body'];
  
  $RouteId = 0;
  
  if(isset($_SESSION['rId'])){
	$RouteId = $_SESSION['rId'];
  }
  if(isset($_SESSION['distance'])){
	$distance = $_SESSION['distance'];
  }else{
	$distance=$_POST['dist'];
  }
  
  if ($dateam=="PM"){
		$datehour=$datehour+12;
  }
   //$datetime=$dateyear-$datemonth-$dateday $datehour:$datemin':00';
   $runningdate = date("y-m-d H:i:s",mktime($datehour,$datemin,00,$datemonth,$dateday,$dateyear));
   $runtime=date("H:i:s",mktime($runhour,$runmin,$runsec));
   echo "$runningdate   $runtime";
    $q="INSERT INTO `RunningLog` (`LogId` ,`UserId` ,`RouteId` ,`Date` ,`Time` ,`Distance` ,`Comments`)VALUES ('NULL' , ".$_POST['user'].", ".$RouteId.", '$runningdate', '$runtime', $distance, '$body')";
  
   mysql_query($q)
   or die(mysql_error());  
   unset($_SESSION['distance'], $_SESSION['rId']);

echo "Data Inserted!";
   
   
   /* Quick self-redirect to avoid resending data on refresh */
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=log&action=view\">";
  // return;
}


?>