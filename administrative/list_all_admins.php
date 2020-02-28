<?php
	require("../connection.php");
	// ===================== SQL Queries Section =====================	
	$sql_list_all_admins = "SELECT * FROM admin";	
	// ===================== SQL Queries Section =====================
?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>All Admins</title>
		<link rel="stylesheet" href = "../stylesheets/list_all_admin_style.css" >
		<style></style>
	</head>
	<body>

	<table>
		<tr>
			<th>Full Name</th>
			<th>Username</th>
		</tr>
<?php
	$statement = $sql_list_all_admins;
	$result = $conn->query($statement);
	while ($row = $result->fetch_assoc()) {
?>
		<tr>
			<td><?php print $row['admin_name']; ?></td>
			<td><?php print $row['username']; ?></td>
		</tr>
<?php
	}
?>
	</table>

<p><a href='administrators.php'>Back to Admin Page</a></p>
	</body>
</html>