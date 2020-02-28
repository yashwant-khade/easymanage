<!-- Only list worklogs that this user created. -->

<?php
  require("../connection.php");
  if (session_id() == "") {session_start();}
  $wrk_id = $_SESSION['curr_user']['wrk_id'];
  // ===================== SQL Queries Section =====================
  $sql_query = "SELECT worklog.log_id AS log_id, entry_date, hours, desp, worklog.proj_id AS proj_id, worklog.task_id AS task_id
								FROM worklog JOIN task ON task.task_id = worklog.task_id
								WHERE assigned_emp_wrk_id = $wrk_id OR supervisior_manager_wrk_id = $wrk_id";
  // ===================== SQL Queries Section =====================
  $worklog_rows = array();
  $statement    = $sql_query;
  $result       = $conn->query($statement);
  $numresults   = mysqli_num_rows($result);
  if($numresults != 0) {
    while($numresults !=0) {
      $rows = $result->fetch_assoc();
      $worklog_rows[] = $rows;
      $numresults--;
    }
  }
?>

<!DOCTYPE html>
<html>

<head >
    <meta charset="utf-8">
    <title>My Worklogs</title>
    <link rel="stylesheet" href = "../stylesheets/user_list_style.css" >
    <style></style>
</head>

<body>
	<h1>My Worklogs</h1>
	<?php if (!empty($worklog_rows)) { ?>
	<table>
		<tr>
		    <th class="thin">ID</th>
		    <th>Date</th>
		    <th class="thin">Hours</th>
		    <th class="wide">Description</th>
		    <th>Project</th>
		    <th>Task</th>
		    <th></th>
		    <th></th>
		</tr>
		<?php for ($i = 0; $i < count($worklog_rows); $i++) { ?>
		<tr>
		  <td class="thin"><?php print $worklog_rows[$i]['log_id']; ?></td>
		  <td><?php print $worklog_rows[$i]['entry_date']; ?></td>
		  <td class="thin"><?php print $worklog_rows[$i]['hours']; ?></td>
		  <td class="wide"><?php print $worklog_rows[$i]['desp']; ?></td>
		  <td><?php print $worklog_rows[$i]['proj_id']; ?></td>
		  <td><?php print $worklog_rows[$i]['task_id']; ?></td>
		  <!-- No SQL query
		  <td class="button_col">
		     <form method="post" action="">
		        <button class="button" name="username" type="submit" value="">Edit</button>
		     </form>
		  </td>
		  -->
			<td class="button_col">
				<form method="post" action="../administrative/prcs/prcs_deleting_a_wrklg.php">
					<button class="button" name="tbd_wrklg" type="submit" value="<?php echo htmlspecialchars($worklog_rows[$i]['log_id']); ?>">Delete</button>
				</form>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } else { ?>
	<p>You don't have any worklog yet!</p>
	<?php } ?>
	<p><a href='dashboard.php'>Back to Dashboard</a></p>

</body>
</html>



