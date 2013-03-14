<?
/******   CREATED BY    ********/
/******   BRAD WOOD     ********/
/******  KYLIE NELSON   ********/
/****** PHIL VanderMeer ********/
/******     MAY 2007    ********/
/?>
				<table width="400px">
					<form action="index.php?cmd=admin&action=writing" method="post">
							<table align="center" cellspacing="0" cellpadding="3" width="340px">
								<tr>
									<td><fieldset id="author" >Author:<br/>
											<select name="author">
												<option>select</option>
												<option>Brad Wood</option>
											</select>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td >Title:</td>
										<td><input type="text" name="title">
										</td>
								</tr>
								<tr>
									<td >Writing:</td><td><textarea rows="2" cols="20" name="text"></textarea>
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
