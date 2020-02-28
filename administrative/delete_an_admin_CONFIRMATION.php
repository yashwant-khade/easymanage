<?php
	require("../connection.php");
	$username = $_POST['username'];
	// ===================== SQL Queries Section =====================	
	$sql_delete_an_admin = "DELETE FROM admin WHERE username = '$username'";	
	// ===================== SQL Queries Section =====================
	$statement = $sql_delete_an_admin;
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
		<p align="center"><?php print $username?> has been successfully deleted</p>
		<p><a href='administrators.php'>Back to Admin Page</a></p>
	</body>
</html>