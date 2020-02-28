<?php
	if (session_id() == "") {session_start();}
	$_SESSION['LoggedIn'] = false;
?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Homepage</title>
		<link rel="stylesheet" href = "stylesheets/index_style.css" >
		<style></style>
	</head>
	<body class="login">
		<p align="center" style="line-height: 50%">EasyManage</p>
		<p align="center" style="font-size: 50%">Log in as...</p>
		<div class="btn_ctn">
			<form method="post" action="user/user_login.php">
				<button class="button" type="submit">User</button>
			</form>
			<form method="post" action="administrative/admin_login.php">
			    <button class="button" type="submit">Admin</button>
			</form>
		</div>
	</body>
</html>