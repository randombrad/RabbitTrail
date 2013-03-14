<h1>About RabbitTRAIL</h1>
<ul>
	<li><img src="./images/bullet_lit_diamond.gif" /> <a href="?cmd=about&action=log" title="View screen shot"> Log your activities</a></li>
	<li><img src="./images/bullet_lit_diamond.gif" /> <a href="?cmd=about&action=routes" title="View screen shot"> Use Google Maps to route where you ran and to find out the distance</a></li>
	<li><img src="./images/bullet_lit_diamond.gif" /> <a href="?cmd=about&action=view" title="View screen shot"> View other users routes</a><li>
</ul>
<br />
<?php
	if (isset($_GET['action'])) { 
		switch ($_GET['action']) {
			case "log":
				echo "<div class=about><br /><br />Here is a screen shot: <br /><br /><img id=about src=\"./images/view_logs.gif\" width=350px ></a></div>";
			break;
			case "view":
				echo "<br /><br />Here is a screen shot: <br /><br /><img src=\"./images/view_all_routes.gif\" ></a>";
			break;
			case "routes":
				echo "<br /><br />Here is a screen shot: <img src=\"./images/create_route.gif\" ></a>";
			break;	
		}
	}
?>
	<br /><br />
<p>Email questions or comments to brad_wood@taylor.edu</p>

	
	