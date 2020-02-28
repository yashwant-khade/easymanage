<?php
	if (session_id() == '') {session_start();}
	session_destroy();
	die(header("Location: ../../index.php"));
?>