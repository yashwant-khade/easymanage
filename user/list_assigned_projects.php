<!-- Only list projects that this user is assigned to. -->

<?php
	require("../connection.php");
	if (session_id() == "") {session_start();}
	$wrk_id = $_SESSION['curr_user']['wrk_id'];
	// ===================== SQL Queries Section =====================
	$sql_query = "SELECT project.proj_id, proj_name, proj_due_date, proj_status, supervisor_dh_wrk_id
	              FROM project JOIN proj_management ON project.proj_id = proj_management.proj_id
	              WHERE manager_wrk_id = $wrk_id";
	// ===================== SQL Queries Section =====================
	$project_rows = array();
	$statement    = $sql_query;
	$result       = $conn->query($statement);
	$numresults   = mysqli_num_rows($result);
	if($numresults != 0) {
		while($numresults !=0) {
		    $rows = $result->fetch_assoc();
		    $project_rows[] = $rows;
		    $numresults--;
		}
	}
?>

<!DOCTYPE html>
<html>

<head >
	<meta charset="utf-8">
	<title>Projects Assigned to Me</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href = "../stylesheets/project_list_style.css" >
	<style></style>
</head>

<body>
    <h1>Projects Assigned to Me</h1>

	<?php if (!empty($project_rows)) { ?>
    <table>
		<tr>
		    <th class="thin">ID</th>
		    <th>Name</th>
		    <th>Due Date</th>
		    <th>Status</th>
		    <th>Supervisor ID</th>
		    <th></th>
		</tr>
		<?php for ($i = 0; $i < count($project_rows); $i++) { ?>
		<tr>
			<td class="thin"><?php print $project_rows[$i]['proj_id']; ?></td>
			<td><?php print $project_rows[$i]['proj_name']; ?></td>
			<td><?php print $project_rows[$i]['proj_due_date']; ?></td>
			<td><?php print $project_rows[$i]['proj_status']; ?></td>
			<td><?php print $project_rows[$i]['supervisor_dh_wrk_id']; ?></td>
			<td class="button_col">
				<?php if (($project_rows[$i]['proj_status'] == "Completed") or ($project_rows[$i]['proj_status'] == "Abandoned")) { ?>
				<button type="button" class="dis_btn" disabled>Edit</button>
				<?php } else { ?>
				<button type="button" class="get_prjId button" data-toggle="modal" data-target="#myModal" data-id="<?php echo htmlspecialchars($project_rows[$i]['proj_id']); ?>">Edit</button>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
    </table>
	<?php } else { ?>
	<p>You don't have any projects assigned to you!</p>
	<?php } ?>

	<p><a class="home" href='dashboard.php'>Back to Dashboard</a></p>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
		  <div class="modal-content"id="modalContent">
				<div class="modal-header">
				  <h4 class="modal-title"id="mdlTitle">Update Status</h4>
				  <button type="button" class="close" data-dismiss="modal" id="mdlTitle">x</button>
				</div>
				<form method="post" action="../administrative/prcs/prcs_upd_stat_asgn_proj.php">
					<div class="modal-body"id="mdlBody">
						<radio>
							<input type="radio" name="status" value="Completed" checked="checked"> Completed<br>
							<input type="radio" name="status" value="In Progress"> In Progress<br>
							<input type="radio" name="status" value="Abandoned"> Abandoned<br>
						</radio>
					</div>
					<div class="modal-footer"id="mdlFooter">
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
			$(".modal-footer #proj_id").val(proj_id);
		});
	</script>
</body>
</html>



