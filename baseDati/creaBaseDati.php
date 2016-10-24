<?php
	require_once('../parameters.php');
	
	// Create connection
	$conn = new mysqli(SERVERNAME, USERNAME_DB, PWD_DB);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	// Create database
	$sql = "CREATE DATABASE " . DBNAMEMAIN . " ";
	if ($conn->query($sql) === TRUE) {
		echo "Database created successfully";
	} else {
		echo "Error creating database: " . $conn->error;
	}
	
	$conn->close();
?>