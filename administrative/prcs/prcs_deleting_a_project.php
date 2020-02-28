<?php
	require("../../connection.php");
	if (session_id() == "") {session_start();}
	$proj_id = $_POST['tbd_proj'];
	//	===================== SQL Queries Section =====================
	/*	Delete a Project (Written by Chay) [Verified by Chay and Zoie]
		(given project id)
		
		// PHP
		DELETE FROM project 
		WHERE proj_id =$proj_id;

		//TEST
		DELETE FROM project 
		WHERE proj_id =1 ;
	*/
	$sql_delete_a_project = "DELETE FROM project WHERE proj_id = $proj_id";	
	//	===================== SQL Queries Section =====================
	$statement = $sql_delete_a_project;
    if (!$conn->query($statement)) {
    	echo "Error: " . $statement . "<br>" . $conn->error;
    }
    die(header("Location: ../../user/list_my_projects.php"));
?>