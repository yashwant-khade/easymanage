<?php
	require("../../connection.php");
	if (session_id() == "") {session_start();}
	$proj_id = $_POST['proj_id'];
	$status  = $_POST['status'];
/*
	Edit Project Status (Written by Chay.) [Verified by Zoie]
	(given the project_id and a new status)
	//PHP
	UPDATE project
	SET proj_status = $status 
	WHERE proj_id = $proj_id ;

	//TEST
	UPDATE project
	SET proj_status = 'In Progress'
	WHERE proj_id = 1;
*/
	$sql_upd_stat = "UPDATE project SET proj_status = '$status' WHERE proj_id = $proj_id";
	$statement = $sql_upd_stat;
    if (!$conn->query($statement)) {
    	echo "Error: " . $statement . "<br>" . $conn->error;
		exit;
    }
    die(header("Location: ../../user/list_my_projects.php"));	
?>










