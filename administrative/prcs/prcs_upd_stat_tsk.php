<?php
	require("../../connection.php");
	if (session_id() == "") {session_start();}
	$proj_id = $_POST['proj_id'];
	$task_id  = $_POST['task_id'];
	$status  = $_POST['status'];
/*
	Edit Task Status (Written by Chay.) [Verified by Zoie]
	(given the task PK ($task_id and $project_id) and a new status)

	//PHP
	UPDATE task
	SET task_status = $status 
	WHERE task_id = $task_id  AND proj_id = $proj_id;

	//TEST
	UPDATE task 
	SET task_status = 'In Progress'
	WHERE task_id = 1  AND proj_id = 1;
*/
	$sql_upd_stat = "UPDATE task SET task_status = '$status' WHERE task_id = $task_id  AND proj_id = $proj_id";
	$statement = $sql_upd_stat;
    if (!$conn->query($statement)) {
    	echo "Error: " . $statement . "<br>" . $conn->error;
    	exit;
    }
    die(header("Location: ../../user/list_my_tasks.php"));
?>










