<?php
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root";
	$db_name= "rtcdatabase";

	// Create connection
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db_name);

	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>