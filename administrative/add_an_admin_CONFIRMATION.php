<?php
	require("../connection.php");
	$admin_name = $_POST['admin_name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	if (empty($admin_name) || empty($username) || empty($password)) {
		die(header("location: add_an_admin.php"));
	}
	// ===================== SQL Queries Section =====================
	$sql_adding_an_admin = "INSERT INTO admin (admin_name, username, password)
							VALUES ('$admin_name', '$username', '$password')";
	// ===================== SQL Queries Section =====================
	$statement = $sql_adding_an_admin;
    if (!$conn->query($statement)) {
    	echo "Error: " . $statement . "<br>" . $conn->error;
    }
?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Confirmation</title>
		<link rel="stylesheet" href = "../stylesheets/add_an_admin_CONFIRMATION_style.css" >
		<style></style>
	</head>
	<body>
		<p align="center"><?php print $admin_name ?> has been successfully added</p>
		<p><a href='administrators.php'>Back to Admin Page</a></p>
	</body>
</html>