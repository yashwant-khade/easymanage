<?php
	require("../../connection.php");
	if (session_id() == "") {session_start();}
	$task_id = $_POST['task_id'];
	$proj_id = $_POST['proj_id'];
	//	===================== SQL Queries Section =====================
	/*	Delete a Task (Written by Chay.) [Verified by Chay and Zoie]
		(given the task PK ($task_id and $project_id))

		//PHP
		DELETE FROM task 
		WHERE task_id = $task_id  AND proj_id =$proj_id;

		//TEST
		DELETE FROM task
		WHERE task_id =1  AND proj_id =1;
	*/
	$sql_delete_a_task = "DELETE FROM task WHERE task_id = $task_id  AND proj_id =$proj_id";	
	//	===================== SQL Queries Section =====================
	$statement = $sql_delete_a_task;
	if (!$conn->query($statement)) {
		echo "Error: " . $statement . "<br>" . $conn->error;
	}
	die(header("Location: ../../user/list_my_tasks.php"));
?>