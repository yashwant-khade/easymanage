<?php require("../connection.php"); ?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Add An Admin</title>
		<link rel="stylesheet" href = "../stylesheets/add_an_admin_style.css" >
		<style></style>
	</head>
	<body>	
		<form method="post" action="add_an_admin_CONFIRMATION.php">
			Full Name: <input type="text" name="admin_name" placeholder="enter your full name here.." autocomplete="off"><br>
			Username:&nbsp&nbsp<input type="text" name="username" placeholder="enter your username here.." autocomplete="off"><br>
			Password:&nbsp&nbsp<input type="password" name="password" placeholder="enter your password here.." autocomplete="off"><br>
			<br>
			<button class="button" type="submit">Add An Admin</button>
		</form>
		<p><a href='administrators.php'>Back to Admin Page</a></p>
	</body>
</html>