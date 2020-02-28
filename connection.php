<?php
	//Connect to the Database
	$servername = "localhost";
	$username = "root";
	$password = "password";

/*	$username = "admin";
	$password = "admin";
*/
	$dbname = "EasyManage";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>