<? 
/******   CREATED BY    ********/
/******   BRAD WOOD     ********/
/******  KYLIE NELSON   ********/
/****** PHIL VanderMeer ********/
/******     MAY 2007    ********/
/* Include Files *********************/
session_start(); 
include_once("connect.php");
include_once("login.php");
/*************************************/


/***** CMD Switch  *********/
if (isset($_GET['cmd'])){ /*check if cmd has been defined*/
	switch ($_GET['cmd']){
		case "logout":		/********   if cmd is logout  **********/
			include_once("connect.php");
			include_once("login.php");
			
			/**
			 * Delete cookies - the time must be in the past,
			 * so just negate what you added when creating the
			 * cookie.
			 */
			if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
			   setcookie("cookname", "", time()-60*60*24*100, "/");
			   setcookie("cookpass", "", time()-60*60*24*100, "/");
			}
			if(!$logged_in){
				//echo "<h1>Error!</h1>\n";
				//echo "You are not currently logged in, logout failed. Back to <a href=\"main.php\">main</a>";
			}
			else{
			   /* Kill session variables */
				unset($_SESSION['username']);
				unset($_SESSION['password']);
				$_SESSION = array(); // reset session array
				session_destroy();   // destroy session.
				$killLogout=1; // Lets down below know that logging out occured
			}
			break;	
		case "reg":
				include_once("register.php");
				if(isset($_POST['subjoin'])){
					include_once("login.php");
				
				}
			break;	
			
		case "login":
				include_once("connect.php");
				include_once("login.php");
			break;	
		
		case "account":
				include_once("connect.php");
				include_once("login.php");
			break;	
		case "log":
				include_once("connect.php");
				include_once("login.php");
		break;	
		
		default:
				include_once("connect.php");
				include_once("login.php"); 
				break; 	
	}	/* <---- END OF CMD SWITCH  **********/
}	/* <---- END OF IF CMD DEFINED?  **********/

/*********** START OF HTML PAGE **********/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<title>Rabbit TRAIL</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8" />
    <?php 
		if(isset($map)) {	
			if ($map=="yes"){?> <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAVEGhP97Xn-Jev5czlKZsBxSLLFF4UFx9kjqD07MUj5kkRBKaNRRfC7AfsM26TuLm7xp6ibLhFX5GWQ" type="text/javascript"></script>
				<script language="Javascript" src="map.js"></script>
		<?php 
				$bodyString='onload="load()" onunload="GUnload()"';
			}
		} /******   CREATED BY    ********/
		
	?>
  </head>
  
  <body <?php if(isset($map)) {	
				if ($map=="yes"){
	echo "$bodyString";
  }
  }?>>
  
<div id="wrapper"><div id="man">
	<h1><img src="images/logo.gif" width="778" height="60" alt="Logo" /></h1>
	<div id="nav">
		<a href="<?php 
			if(isset($_GET['map'])) {
				$map=$_GET['map'];
				if ($map=="yes"){
					echo "?cmd=login";
				}
				}else{
					echo "?cmd=login&map=yes";
				}
					?>"><img src="images/m1.gif" width="246" height="30" alt="GoogleMaps" /></a>
		<a href="?cmd=log"><img src="images/m2.gif" width="246" height="25" alt="M2" title="View Running Logs"/></a>
		<a href="http://www.freewebsitetemplates.com"><img src="images/m3.gif" width="246" height="25" alt="M3" /></a>
		<a href="http://www.freewebsitetemplates.com"><img src="images/m4.gif" width="246" height="24" alt="M4" /></a>
		<a href="http://www.freewebsitetemplates.com"><img src="images/m5.gif" width="246" height="25" alt="M5" /></a>
		<a href="http://www.freewebsitetemplates.com"><img src="images/m6.gif" width="246" height="23" alt="M6" /></a>
		<a href="http://www.freewebsitetemplates.com"><img src="images/m7.gif" width="246" height="25" alt="M7" /></a>
		<img src="images/m8.gif" width="246" height="35" alt="M8" />
	</div>
	<div id="body"><div style="position: relative; left: -250px; top:-40px;"><h3 class="logotext">RabbitTRAIL</h3></div>
	<div id="status">
	<?php 	
	
	// USER INFO LINE	
			if(isset($logged_in) && $logged_in && isset($_SESSION['username'])){   //<--- changed from "$_session['username'] "to "isset($_session['username']"
				$today = date("m.d.y");     
				echo "$today | Welcome ".$_SESSION['username']." | <a href=\"index.php?cmd=logout\">Log-out </a>|";
				echo '<a href="?cmd=account"> Account Info </a>|';
			}else{
				if (isset($killLogout) && $killLogout){
				echo "(You have successfully <b>logged out</b>) ";
				$killLogout=0;
				echo '|<a href="index.php?cmd=reg"> Sign-up  </a>|<a href="index.php?cmd=login">Member Login </a>|';
				}else
					echo '|<a href="index.php?cmd=reg"> Sign-up </a>|<a href="index.php?cmd=login">Member Login </a>|';
				}
				
	// END OF USER INFO LINE
	?>
	</div>
		<div class="drk" id="welcome">
		
			<div class="top">
				<div class="bot">
				<div class="picbar"><img src="images/pic_2.jpg" width="458" height="103" alt="Pic 2" /></div>
					<div class="pad">
						<h2><img src="images/h_welcome_to_our_club.gif" width="137" height="17" alt="Welcome To Our Club" /></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="drk" id="news">
			<div class="top">
				<div class="bot">
					<div class="pad">
					<?php 
							
							if(isset($_GET['cmd']) && $_GET['cmd']=="login"){
								displayLogin();
							}
							if (isset($_GET['cmd']) && $_GET['cmd']=="reg"){
								echo "	<table><tr><td><h3>Sign-UP</h3></td></tr>	
											<form action=\"index.php?cmd=reg\" method=\"post\">
												<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
													<tr><td>Username* :</td><td><input type=\"text\" name=\"user\" maxlength=\"30\"></td></tr>
													<tr><td>Password* :</td><td><input type=\"password\" name=\"pass\" maxlength=\"30\"></td></tr>
													<tr><td>Birthdate* :</td><td>
													
													<label for=\"birthday\">Month   &nbsp;&nbsp;&nbsp; </label>
													<label for=\"birthday\">Day</label>
													<label for=\"birthday\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year</label>
													<fieldset id=\"birthday\">
														<select name=\"bdmonth\">
															<option>--</option>";
														for ($i=1; $i<=12;$i++){
															echo "<option>$i</option>";
																										
														}
														echo "</select>	<select name=\"bdday\"><option>--</option>";
														for ($i=1; $i<=31;$i++){
															echo "<option>$i</option>";
																										
														}
														echo "</select><select name=\"bdyear\"><option>--</option>";
																					
														for ($i=2010; $i>1900;$i--){
															echo "<option>$i</option>";
														}
														echo "</select>
													</fieldset>
													</td></tr>
													<tr><td>Email:</td><td><input type=\"email\" name=\"email\"></td></tr>
													<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" name=\"subjoin\" value=\"Join!\"></td></tr>
												</table>
								</form></table>";
							}
							if(isset($_GET['cmd']) && $_GET['cmd']=="log"){
								include_once("log.php");
							}
							?>
							<div class="clear"></div>
					<h2><img src="images/h_current_sports_news.gif" width="117" height="21" alt="Current Sports News" /></h2>
						
						<h3>20-12-06</h3>
							 
						  <?php 
								if (isset($cmd) && $_GET['cmd']=="account"){
									include_once("account.php");
								}
						  
								if(isset($map)) {	
									if ($map=="yes"){
									
										include_once("map.php");
									} //CLOSES IF $MAP==YES
								}
						?>
						<?php //<p class="more"><a href="?cmd=" class="diamond">Know more</a></p> ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="lit" id="features">
			<div class="top">
				<div class="bot">
					<div class="pad">
						<h2><img src="images/h_featured_events.gif" width="97" height="17" alt="Featured Events" /></h2>
						<div class="event">
							<h3>23-12-06</h3>
							<p><?php
							include_once("connect.php");
								$sql="SELECT * FROM UserLog";
								$result=mysql_query($sql);
								if (!$result) {
									echo 'Could not run query: ' . mysql_error();
									exit;
								}
								echo "<table><tr><td>UserID</td>\n<td>UserName</td>\n<td>Password</td>\n</tr>";
									while($row=mysql_fetch_array($result)){
										echo "<tr><td>$row[0]</td>"; // 42
										echo "<td>$row[1]</td>\n"; 
										echo "<td>$row[2]</td></tr>\n"; 
									}
								echo "</table>";
							?>
							</p>
							
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div></div>
<div id="foot">
	<div id="foot-left">
		<div id="foot-ball"></div>
		&copy; RabbitTrail All right Reservered. 
	</div>
	<a href="http://validator.w3.org/check?uri=http://www2.css.tayloru.edu/~cos264s0707/index.php" class="work"><img src="images/valid_xhtml11.png" class="floatRight" alt="Valid XHTML 1.1!" /></a>
</div>
  </body>
</html>
<?php 
/********  END OF HTML PAGE  **********/
?>
