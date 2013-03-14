<?
/******   CREATED BY    ********/
/******   BRAD WOOD     ********/
/******  KYLIE NELSON   ********/
/****** PHIL VanderMeer ********/
/******     MAY 2007    ********/

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

?>
<table align="center">
<tr width="300px">
	<td>| <a href="?cmd=account&action=update">UPDATE ACCOUNT INFO</a></td><td>| <a href="?cmd=account&action=view">VIEW ACCOUNT INFO</a>|</td></tr>
	<tr><td><br/></td></tr>
</table>


<?php

/******     EDIT RUNNER'S LOG    ********/	
if(isset($_GET['action']) && $_GET['action']=="update"){	//VIEW ALL OF THE USER'S LOGS print (getUserId())
		
			$id2=getUserId();
			$sql="SELECT * FROM UserData WHERE UserId = '$id2'";
			$result=mysql_query($sql);
			if (!$result) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			while($row=mysql_fetch_array($result)){
	?>
				<table width="400px"  >
					<form action="index.php?cmd=account&action=update" method="post">
							<table align="center" cellspacing="0" cellpadding="3" width="340px">
								<tr ><input type="hidden" name="userid" value="<?php print (getUserId())?>"></td></tr>
								<tr>
									<td colspan="1.5" width="150px" align="center">
										<fieldset id="weigtht" >Weight:<br/>
											<select name="lbs">
												<option><?php echo "$row[2]"; ?></option>";
												<?php	
													for ($i=40; $i<=400;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> lbs.
										</fieldset>
									</td>
									<td width="150px"  align="center">
										<fieldset id="height">Height:<br/>
										<?php
											$feet=$row[3]/12;
											$feet1=intval($feet);
											$inches = $row[3] % 12;
										?>
											<select name="heightFoot">
												<option><?php echo "$feet1"; ?></option>";
												<?php	
													for ($i=3; $i<=7;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> feet
											<select name="heightInch">
												<option><?php echo "$inches"; ?></option>";
												<?php	
													for ($i=0; $i<=11;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> inches
										</fieldset>
									</td>
								</tr>
								<tr>
									<td width="150px" align="center">
										<fieldset id="RestingHeartRate" >Resting Heart Rate:<br/>
											<select name="RHR">
												<option><?php echo "$row[6]"; ?></option>";
												<?php	
													for ($i=25; $i<=100;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> b.p.m.
										</fieldset>
									</td>
									<td width="150px" align="center">
										<fieldset id="ActiveHeartRate">Active Heart Rate:<br/>
											<select name="AHR">
												<option><?php echo "$row[7]"; ?></option>";
												<?php	
													for ($i=80; $i<=200;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> b.p.m.
										</fieldset>
									</td>
								</tr>
								<tr colspan="5" width="200px">
									<td  colspan="5" align="center" >
											<label for="date">Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
											<label for="date">Day</label>
											<label for="date">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year</label>
										<fieldset id="date\">Birthday:
										<?php 
										$_bday=explode("-",$row[4]);
										?>	
											<select name="month">
												<option><?php echo "$_bday[1]"; ?></option>";
												<?php	
													for ($i=1; $i<=12;$i++){
														echo "<option>$i</option>";
													} 
												?>
											</select> /
											<select name="day">
												<option><?php echo "$_bday[2]" ?></option>
												<?php
													for ($i=1; $i<=31;$i++){
														echo "<option>$i</option>";
													}
												?>	
											</select> /
											<select name="year">
												<option><?php echo "$_bday[0]" ?></option>
												<?php
													for ($i=2010; $i>1900;$i--){
														echo "<option>$i</option>";
													}
												?>
											</select> ex: 2/4/2007
										</fieldset>
									</td>
								</tr>
								<tr colspan="5" width="200px">
									<td  colspan="5" align="center" >
									<?php 
									
									$_runtime = explode(":",$row[5]);
									
									?>
									<label for="rtime">&nbsp;Hours   &nbsp;&nbsp;&nbsp; </label>
										<label for="rtime">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mins</label>
													<label for="rtime">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sec</label>
																							
										<fieldset id="rtime\">1 Mile Run Time:<br/>
												<select name="rh">
													<option><?php echo "$_runtime[0]"; ?></option>";
													<?php	
														for ($i=0; $i<=12;$i++){
															echo "<option>$i</option>";
														} 
													?>
												</select> :
												<select name="rm">
													<option><?php echo "$_runtime[1]"; ?></option>
													<?php
														for ($i=0; $i<=59;$i++){
															echo "<option>$i</option>";
														}
													?>	
												</select> :
												<select name="rs">
													<option><?php echo strftime ("%S", strtotime($row[6])); ?></option>
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
									<td  align="center" >Email:</td>
										<td><input type="text" name="email" value="<?php echo "$row[8]";?>">
										</td>
								</tr>
								<tr>
								<td align="center"><img src="./images/man_icon.png"/ width="100px"><br/><input type="radio" name="userpic" value="/images/man_icon.png" <?php if($row[9]=="\/images/man_icon.png"){echo "checked";}?>></td><br>
								<td align="center"><img src="./images/female_icon.png"/ width="100px"><br/><input type="radio" name="userpic" value="/images/female_icon.png" <?php if($row[9]=="\/images/female_icon.png"){echo "checked";}?>></td><br>
								<td align="center"><img src="./images/male_icon.png"/ width="100px"><br/><input type="radio" name="userpic" value="/images/male_icon.png" <?php if($row[9]=="\/images/male_icon.png"){echo "checked";}?>>
									</td>
								</tr>
																
												<input type="hidden" name="updateaccount" value="1">
									<tr><td colspan="2" align="right"><input type="submit" name="sublog" value="Edit Log"></td></tr>
									</table>
											</form></table>
		<?php
		
		}/******     END OF ISSET $id    ********/
	if(isset($_POST['updateaccount'])){
	   $userid=$_POST['userid'];
	   $weight=$_POST['lbs'];
	   if(isset($_POST['height'])){
			$height=$_POST['height'];
		}
	   $dateyear=$_POST['year'];
	   $datemonth=$_POST['month'];
		$dateday=$_POST['day'];
		
		 $runhour=$_POST['rh'];
		$runmin=$_POST['rm'];
		$runsec=$_POST['rs'];
	   	$miletime1="$runhour:$runmin:$runsec";
		
		$hf=$_POST['heightFoot'];
		$hi=$_POST['heightInch'];
		
		$hf=$hf*12;
		$hi=$hi+$hf;
		
		$RHR=$_POST['RHR'];
		$AHR=$_POST['AHR'];
		$email=$_POST['email'];
		
		$userpic=$_POST['userpic'];
		
		//$miletime=strftime ("%H:%M:%S", strtotime($miletime1));
		$birthday = "$dateyear-$datemonth-$dateday";
	  
	    //$datetime=$dateyear-$datemonth-$dateday $datehour:$datemin':00';
	    //$q="UPDATE `RunningLog` SET `UserId` = ".$_POST['user'].",`RouteId` = '0',`Date` = '$runningdate',`Time` = '$runtime',`Distance` = ".$distance.", `Comments` = '$body' WHERE 'LogId` = ".12."";
		//SERT INTO `cos264s0707`.`RunningLog` (`LogId` ,`UserId` ,`RouteId` ,`Date` ,`Time` ,`Distance` ,`Comments`)VALUES ('NULL' , ".$_POST['user'].", '0', '$runningdate', '$runtime', ".$distance.", '$body')";
	  //$q="INSERT INTO `cos264s0707`.`RunningLog` (`LogId` ,`UserId` ,`RouteId` ,`Date` ,`Time` ,`Distance` ,`Comments`)VALUES ('NULL' , ".$_POST['user'].", '0', '$runningdate', '$runtime', ".$distance.", '$body')";
	  //UPDATE `cos264s0707`.`UserData` SET `Updated` = NOW( ) ,`Weight` = '52',`Height` = '59' WHERE `UserData`.`UserId` =3 
	   $result=mysql_query("UPDATE `UserData` SET `Updated` = NOW( ), Weight = ".$weight.", Height = ".$hi.", BDay= '$birthday', MileTime= '$miletime1', RHR = ".$RHR.", AHR=".$AHR.", email='$email', pic='$userpic' WHERE `UserId` = ".$userid."");;
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	 
	
	echo "Data Inserted!";
	   
	   
	   /* Quick self-redirect to avoid resending data on refresh */
	   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=account&action=view\">";
	  // return;
	}
}

if(isset($_GET['action']) && $_GET['action']=="view"){	//VIEW ALL OF THE USER'S LOGS print (getUserId())
/*** OLD ACCOUNT   ***/
	$user=$_SESSION['username'];
	$sql="SELECT UserData.* FROM UserData LEFT JOIN UserLog ON UserLog.UserId = UserData.UserId WHERE UserLog.UserName = '$user'";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	
	if (isset($_GET['action']) && $_GET['action'] == 'edit'){
	echo "this is action";

	}else{
  
	echo "<table>\n";
		while($row=mysql_fetch_array($result)){
		$_lupdated=explode(" ",$row[1]);
		$_ldate=explode("-",$_lupdated[0]);
		$_ldate=explode("-",$_lupdated[1]);
			echo "<table width=\"400px\">\n";
							
				echo "<tr bgcolor=\"#362E2B\"><td><i>Last Updated</i></td><td>$row[1]</td></tr>"; 
				echo "<tr bgcolor=\"#362E2B\"><td>Weight</td><td>$row[2] lbs.</td></tr>"; 
				$feet=$row[3]/12;
			$feet1=intval($feet);
			$inches = $row[3] % 12;
				echo "<tr bgcolor=\"#362E2B\"><td>Height</td><td>$feet1' $inches\"</td></tr>"; 
				echo "<tr bgcolor=\"#362E2B\"><td>Birth Date</td><td>$row[4]</td></tr>";
				echo "<tr bgcolor=\"#362E2B\"><td>Email</td><td>$row[8]</td></tr>";
				echo "<tr bgcolor=\"#362E2B\"><td><span title='Usal Time you run a mile in'>Mile Time</span></td><td>$row[5]</td></tr>"; 
				echo "<tr bgcolor=\"#362E2B\"><td>Resting Heart Rate</td><td>$row[6]</td></tr>"; 
				echo "<tr bgcolor=\"#362E2B\"><td>Active Heart Rate</td><td>$row[7]</td></tr>"; 
						
				
			}
		echo "</table>\n";
		}
	echo "</table>";

}
/*** OLD ACCOUNT   ***/

?>

<?
/******   CREATED BY    ********/
/******   BRAD WOOD     ********/
/******  KYLIE NELSON   ********/
/****** PHIL VanderMeer ********/
/******     MAY 2007    ********/

	
//This Grabs the User Id for the user that is currently Logged in	

?>
