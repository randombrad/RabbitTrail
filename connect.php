<?php
// db info
$hostname="h50mysql13.secureserver.net";
$mysql_login="rabbitadmin";
$mysql_password="Rabbit07";
$database="rabbitadmin";

if (!($db = mysql_connect($hostname, $mysql_login , $mysql_password))){
die("Can't connect to mysql.");
}else{
if (!(mysql_select_db("$database",$db))) {
die("Can't connect to db.");
}
}
?> 