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
			if ($map=="yes"){?> <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAVEGhP97Xn-Jev5czlKZsBxRT8El_-6A6_yjzMm131f3YY80vEhTm6JzYeCo0BNRg58FdCAGYwp6xZQ" type="text/javascript"></script>
				<script type = "text/javascript" src = "sarissa.js"></script> 
				<script type="text/javascript" src="map2.js"></script>
		<?php 
				$bodyString='onload="drawMap()" onunload="GUnload()"';
			}
		} /******   CREATED BY    ********/
		
	?>
  </head>
  
  <body <?php if(isset($map)) {	
				if ($map=="yes"){
	echo "$bodyString";
  }
  }?>>
  
<div id="wrapper">
	<div id="man">
		<h1><img src="images/logo.gif" width="778" height="60" alt="Logo" /></h1>
		<div id="nav">
			<a href="?"><img src="images/m1.gif" width="246" height="30" alt="GoogleMaps" /></a>
			<a href="?cmd=log"><img src="images/m2.gif" width="246" height="25" alt="M2" title="View Running Logs"/></a>
			<a href="?cmd=graph"><img src="images/m3.gif" width="246" height="25" alt="M3" title="Graphs" /></a>
			<a href="<a href="<?php 
				if(isset($_GET['cmd'])) {
					
					
					if ($_GET['cmd']=="map"){
						echo "index.php";
					}else{
						echo "?cmd=map";
					}
				}
						?>"><img src="images/m4.gif" width="246" height="24" alt="M4" /></a>
			<a href="?cmd=map"><img src="images/m5.gif" width="246" height="25" alt="M5" /></a>
			<img src="images/m8.gif" width="246" height="35" alt="M8" />
		</div><!-- CLOSING NAV DIV -->
		<div id="body">
			<div style="position: relative; left: -250px; top:-20px;"><h3 class="logotext">RabbitTRAIL</h3></div>
			<div id="status">
				<?php 	
				// USER INFO LINE	
					if(isset($logged_in) && $logged_in && isset($_SESSION['username'])){   //<--- changed from "$_session['username'] "to "isset($_session['username']"
						$today = date("m.d.y");     
						echo "$today | Welcome ".$_SESSION['username']." | <a href=\"index.php?cmd=logout\">Log-out </a>|";
						echo '<a href="?cmd=account&action=view"> Account Info </a>|';
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
			
			<div class="pagelink">
				<ul><a href="index.php">Home</a></ul>
				<ul><a href="?cmd=log" title="Update your log and view other user's logs">Activity Logs</a></ul>
				<ul><a href="?cmd=graph">Graphs</a></ul>
				<ul><a href="<?php 
							if (isset($_GET['cmd']) && $_GET['cmd']=="map"){
								echo "index.php";
							}else{
								echo "index.php?cmd=map";
							}
						
								?>" title="Update and view routes">Routes</a></ul>
					<ul><a href="?cmd=about">About</a></ul>
				
			</div><!-- CLOSING PAGELINK DIV -->
			</div><!-- CLOSING STATUS DIV -->
			<div class="drk" id="welcome">
				<div class="bot">
					<div class="picbar">
						<img src="images/pic_2.jpg" width="458" alt="Pic 2" /><h2><img src="images/h_welcome_to_our_club.gif" width="137" height="17" alt="Welcome To Our Club" /></h2>
					</div> <!-- CLOSING PICBAR DIV -->
				</div> <!-- CLOSING BOT DIV -->
			</div><!-- CLOSING DRK DIV -->
			<div class="lit" id="features">
				<div class="top">
					<div class="bot">
						<div class="pad">
							<?php 	
								if (!isset($_SESSION['username']) && isset($_GET['cmd']) && $_GET['cmd']!="login" && $_GET['cmd']!="reg"){
									echo "<h2>Please <a href=\"?cmd=reg\"><u>Sign-up</u></a> or <a href=\"?cmd=login\"><u>Login</u></a></h2><br />";
								}
								if (!isset($_SESSION['username']) && !isset($_GET['cmd'])){
									echo "<h2>Please <a href=\"?cmd=reg\"><u>Sign-up</u></a> or <a href=\"?cmd=login\"><u>Login</u></a></h2><br />";
							
								}
								if(isset($_GET['cmd']) && $_GET['cmd']=="about"){
									include("about.php");
								}
								if(isset($_SESSION['username']) && !isset($_GET['cmd'])){
									echo "<h3>Please select a link from the menu to the left</h3><br />";
								}
							if(isset($_GET['cmd']) && $_GET['cmd']=="graph" && isset($_SESSION['username'])){
								include("graph.php");
							}
							if(isset($_GET['cmd']) && $_GET['cmd']=="account" && isset($_SESSION['username'])){
								include("account.php");
							}
							if(isset($_GET['cmd']) && $_GET['cmd']=="log" && isset($_SESSION['username'])){
								include_once("log.php");
							}
							if(isset($_GET['cmd']) && $_GET['cmd']=="login"){
								displayLogin();
							}
							if (isset($_GET['cmd']) && $_GET['cmd']=="reg"){
								echo "	<table><tr><td><h3>Sign-up</h3></td></tr>	
											<form vname=\"info\" onSubmit=\"return checkform()\"action=\"index.php?cmd=reg\" method=\"post\">
												<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" with=\"300px\">
													<tr><td>Username* :</td><td><input type=\"text\" name=\"user\" maxlength=\"30\"></td></tr>
													<tr><td>Password* :</td><td><input type=\"password\" name=\"pass\" maxlength=\"30\"></td></tr>
													<tr><td>Re-Type Password* :</td><td><input type=\"password\" name=\"pass2\" maxlength=\"30\"></td></tr>
													
													<tr><td><label for=\"email\">Email Address:</label></td><td><input type=\"email\" name=\"email\" id=\"email\"></td></tr>
													<tr><td colspan=\"3\"><h3><span id=\"error_email\" class=\"errormessage\"></span></h3></td></tr>
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
													</td></tr><tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" name=\"subjoin\" value=\"Join!\"></td></tr>
												</table>
								</form></table>";
							}
							
							if(isset($_GET['cmd']) && $_GET['cmd']=="map" && isset($_SESSION['username'])){
								include_once("login.php");
								include_once("map.php");
							}
								?>
						</div> <!-- CLOSING PAD DIV -->
						<div class="clear"></div>
					</div><!-- CLOSING BOD DIV -->
				</div><!-- CLOSING TOP DIV -->
			</div><!-- CLOSING LIT DIV -->
		</div><!-- CLOSING BODY DIV -->
	<div class="clear"></div>
</div></div>
<div id="foot">
	<div id="foot-left">
		<div id="foot-ball"></div>
		&copy; RabbitTrail All right Reservered. 
	</div>
	<a href="http://validator.w3.org/check?uri=http://randombrad.com/RabbitTRAIL/index.php" class="work"><img src="images/valid_xhtml11.png" class="floatRight" alt="Valid XHTML 1.1!" /></a>
</div>
  </body>
</html>
<?php 
/********  END OF HTML PAGE  **********/
?>
