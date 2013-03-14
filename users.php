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