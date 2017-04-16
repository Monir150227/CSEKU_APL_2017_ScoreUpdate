<?php

//connect to server and database
error_reporting(0);
$conn=mysqli_connect("localhost","root","","update_score");
 if(!$conn)
 {
	 die("Failed to connect ".mysqli_connect_error());
 }
?>
