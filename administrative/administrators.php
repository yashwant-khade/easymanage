<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	// ===================== SQL Queries Section =====================
	$sql_query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
	// ===================== SQL Queries Section =====================
	require("../connection.php");
	if (session_id() == "") {session_start();}
	if (!$_SESSION['ad_loggedIn']) {
		$statement = $sql_query;
		$result = $conn->query($statement);
		$numresults = mysqli_num_rows($result);
		if($numresults != 1) {
			die(header("Location: admin_login.php"));
		}
		$_SESSION['ad_loggedIn'] = true;
	}
?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Admistrators</title>
		<link rel="stylesheet" href = "../stylesheets/administrators_style.css" >
		<style></style>
	</head>
	<body>
		<p align="center">Select your action..</p>
		
		<div class="btn_ctn">
			<form method="post" action="list_all_admins.php">
				<button class="button" type="submit">LIST ALL</button>
			</form>
			<form method="post" action="add_an_admin.php">
				<button class="button" type="submit">ADD</button>
			</form>
			<!--
			<form method="post" action="administrators.php">
				<button class="button" type="submit">UPDATE</button>
			</form> -->
			<form method="post" action="delete_an_admin.php">
				<button class="button" type="submit">DELETE</button>
			</form>
		</div>
		<p>
			<!--
			<a href='../index.php'>Back to Homepage</a>
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp -->
        	<a href='prcs/prcs_signout.php'>Signout</a>
		</p>
	</body>
</html>
















