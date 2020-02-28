<!-- Only list tasks that this user supervises. -->

<?php
	require("../connection.php");
	if (session_id() == "") {session_start();}
	$wrk_id = $_SESSION['curr_user']['wrk_id'];
	// ===================== SQL Queries Section =====================
	$sql_query =   "SELECT task_id, task_name, task_due_date, task_status, task.proj_id AS proj_id, assigned_emp_wrk_id
					FROM task JOIN  proj_management  ON task.proj_id = proj_management.proj_id
					WHERE manager_wrk_id = $wrk_id";
	// ===================== SQL Queries Section =====================
	$task_rows = array();
	$statement    = $sql_query;
	$result       = $conn->query($statement);
	$numresults   = mysqli_num_rows($result);
	if($numresults != 0) {
		while($numresults !=0) {
		    $rows = $result->fetch_assoc();
		    $task_rows[] = $rows;
		    $numresults--;
		}
	}
?>

<!DOCTYPE html>
<html>

<head >
	<meta charset="utf-8">
	<title>My Tasks</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href = "../stylesheets/project_list_style.css">
	<style></style>
</head>

<body>
	<h1>My Tasks</h1>

	<?php if (!empty($task_rows)) { ?>
	<table>
		<tr>
			<th class="thin">ID</th>
			<th>Name</th>
			<th>Due Date</th>
			<th>Status</th>
			<th>Project</th>
			<th>Assignee ID</th>
			<th></th>
			<th></th>
		</tr>
		<?php for ($i = 0; $i < count($task_rows); $i++) { ?>
		<tr>
			<td class="thin"><?php print $task_rows[$i]['task_id']; ?></td>
			<td><?php print $task_rows[$i]['task_name']; ?></td>
			<td><?php print $task_rows[$i]['task_due_date']; ?></td>
			<td><?php print $task_rows[$i]['task_status']; ?></td>
			<td><?php print $task_rows[$i]['proj_id']; ?></td>
			<td><?php print $task_rows[$i]['assigned_emp_wrk_id']; ?></td>
			<td class="button_col">
				<?php if (($task_rows[$i]['task_status'] == "Completed") or ($task_rows[$i]['task_status'] == "Abandoned")) { ?>
				<button type="button" class="dis_btn" disabled>Edit</button>
				<?php } else { ?>
				<button type="button" class="get_prjId button" data-toggle="modal" data-target="#myModal" data-id="<?php echo htmlspecialchars($task_rows[$i]['proj_id']); ?>" data-idtsk="<?php echo htmlspecialchars($task_rows[$i]['task_id']); ?>" data-stt="<?php echo htmlspecialchars($task_rows[$i]['task_status']); ?>">Edit</button>
				<?php } ?>
			</td>
			<td class="button_col">
			  <form method="post" action="../administrative/prcs/prcs_deleting_a_task.php">
					<input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_rows[$i]['task_id']); ?>">
					<input type="hidden" name="proj_id" value="<?php echo htmlspecialchars($task_rows[$i]['proj_id']); ?>">
					<button class="button" name="$tbd_task" type="submit">Delete</button>
				</form>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } else { ?>
	<p>You haven't created any tasks!</p>
	<?php } ?>

	<p><a class="home" href='dashboard.php'>Back to Dashboard</a></p>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
		  <div class="modal-content"id="modalContent">
				<div class="modal-header">
				  <h4 class="modal-title"id="mdlTitle">Update Status</h4>
				  <button type="button" class="close" data-dismiss="modal" id="mdlTitle">x</button>
				</div>
				<form method="post" action="../administrative/prcs/prcs_upd_stat_tsk.php">
					<div class="modal-body"id="mdlBody">
						<radio>
							<input type="radio" name="status" value="Completed" checked="checked"> Completed<br>
							<input type="radio" name="status" value="In Progress"> In Progress<br>
							<input type="radio" name="status" value="Abandoned"> Abandoned<br>
						</radio>
					</div>
					<div class="modal-footer"id="mdlFooter">
						<input type="hidden" data-toggle="modal" name="task_id" id="task_id">
						<button type="submit" class="btn btn-primary" data-toggle="modal" name="proj_id" id="proj_id">
						Submit
						</button>
					</div>
				</form>
		  </div>
		</div>
	</div>
	<script>
		$(document).on("click", ".get_prjId", function () {
			var proj_id = $(this).data('id');
			var task_id = $(this).data('idtsk');
			var task_status = $(this).data('stt');
			$(".modal-footer #proj_id").val(proj_id);
			$(".modal-footer #task_id").val(task_id);
		});
	</script>
</body>
</html>