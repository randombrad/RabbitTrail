<?php
	include_once("connect.php");
	
	$sql=" SELECT * FROM `RunningLog`";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	
		

	$user_id="Brad Wood";
	echo "
<chart>
	<chart_type>line</chart_type>
   <chart_data>
      <row>
         <null/>
         <string>$user_id</string>
         <string>2002</string>
      </row><row>
         <string>Log Id</string>";
	  while($row=mysql_fetch_array($result)){
      echo "
         <number>$row[1]</number>
		 <number>$row[0]</number>";}
      echo "</row>
      <row>
         <string>User Id</string>";
		 while($row=mysql_fetch_array($result)){
      echo "
         <number>$row[0]</number>";
		 }
		 echo "
      </row>";
	  while($row=mysql_fetch_array($result)){
      echo "
         <number>$row[0]</number>
		 ";}
      echo "</row>
      <row>
         <string>User Id</string>";
		 while($row=mysql_fetch_array($result)){
      echo "
         <number>$row[1]</number>";
		 }
		 echo "
      </row>
	  
   </chart_data>
</chart>
";

?>