<?php
	require("../connection.php");
	if (session_id() == "") {session_start();}
    if (isset($_SESSION['user_loggedIn'])) {
        die(header("Location: dashboard.php"));
    }
?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Authentication</title>
		<link rel="stylesheet" href = "../stylesheets/admin_login_style.css" >
		<style></style>
	</head>
	<body>
		<form method="post" action="dashboard.php">
			User ID: &nbsp<input type="text" name="wrk_id" placeholder="enter your username here.." autocomplete="off"><br>
			Password: <input type="password" name="password" placeholder="enter your password here.." autocomplete="off"><br>
			<br>
			<button class="button" type="submit">Submit</button>
		</form>
		<p><a href="../index.php">Back to Homepage</a></p>
	</body>
</html>