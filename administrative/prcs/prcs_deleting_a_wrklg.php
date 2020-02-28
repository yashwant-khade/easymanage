<?php
	require("../../connection.php");
	if (session_id() == "") {session_start();}
	$log_id = $_POST['tbd_wrklg'];
	print($log_id);
	$sql_delete_a_wrklg = "DELETE FROM worklog WHERE log_id = $log_id";
	$statement = $sql_delete_a_wrklg;
    if (!$conn->query($statement)) {
    	echo "Error: " . $statement . "<br>" . $conn->error;
    }
    die(header("Location: ../../user/list_my_worklogs.php"));
?>