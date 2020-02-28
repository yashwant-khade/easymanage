<?php require("../connection.php"); ?>
<?php require("../mylogger.php"); ?>

<?php
$loginShow = "";
function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";

}
session_start();
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
$my_position = $_SESSION['curr_user']['position'];

$query1="(SELECT wrk_name, wrk_id
FROM worker
WHERE '$my_position' = 'Manager' AND wrk_id != $my_wrk_id AND wrk_id IN 
(SELECT emp_wrk_id
FROM employee_management
WHERE manager_wrk_id = $my_wrk_id))
UNION
(SELECT wrk_name, wrk_id
FROM worker
WHERE '$my_position' = 'Department Head' AND wrk_id != $my_wrk_id AND wrk_id IN 
	(SELECT emp_wrk_id
	FROM employee
	WHERE works_for_dept_name IN
(SELECT leads_dept_name 
FROM department_head
WHERE dh_wrk_id = $my_wrk_id)))
UNION
(SELECT wrk_name, wrk_id
FROM worker
WHERE '$my_position' = 'Director');
";

if (isset($_POST['create_bonus_click'])) {

    $assigned_emp_wrk_id = $_POST['worker_id'];
    $task_name = $_POST['task_name'];
    $task_status = 'Not Started';
    $task_due_date = $_POST['due_date'];
    $proj_id = $_POST['proj_id'];

    if(is_numeric($assigned_emp_wrk_id) && trim($task_name) != "" && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$task_due_date)){
        $query4 = "INSERT INTO task(task_name, task_due_date, task_status, proj_id, assigned_emp_wrk_id,supervisior_manager_wrk_id)
       VALUES('$task_name', '$task_due_date', '$task_status', $proj_id, $assigned_emp_wrk_id, $my_wrk_id);
";

        if ($conn->query($query4) === TRUE) {
            alert("Successfully added task!");
            myLogger('Added task to task table', 'CREATE TASK','Success');

        } else {
            echo "Error: " . $query4 . "<br>" . $conn->error;
            myLogger('Added task to task table'.$conn->error, 'CREATE TASK','Error');
        }
    }else
    {
        alert("Please enter valid data");
        myLogger('Data entered is not valid'.$conn->error, 'CREATE TASK','Warning');
    }
}


$result_users = $conn->query($query1);
if ($result_users->num_rows == 0) {
    echo "Not Authorized";
    $loginShow='display: none';
    myLogger('Not authorized as no users in the dropdown', 'CREATE TASK','Warning');
}else
{
    $loginShow = '';
    myLogger('Authorized and loaded data successfully', 'CREATE TASK','Info');

}
$query2 = "SELECT proj_name, proj_id
FROM proj_management NATURAL JOIN project
WHERE manager_wrk_id = $my_wrk_id OR supervisor_dh_wrk_id = $my_wrk_id;
";
$result_years = $conn->query($query2);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add An Admin</title>
    <link rel="stylesheet" href="../stylesheets/create_style.css">
    <style></style>
</head>
<body>

<form method="post"
      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
      ?>" style="<?php echo $loginShow?>">


    <table class="create">
        <tr>
            <td>
                Select Employee:
            </td>
            <td class="long">
                <select class="select-css" name="worker_id">
                    <?php
                    while ($row = mysqli_fetch_array($result_users)) {
                        echo "<option value='" . $row['emp_wrk_id'] . "'>" . $row['wrk_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Select Project:</td>
            <td class="long">
                <select class="select-css" name="proj_id">
                    <?php
                    while ($row1 = mysqli_fetch_array($result_years)) {
                        echo "<option value='" . $row1['proj_id'] . "'>" . $row1['proj_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Task Name:</td>
            <td>
                <input type="text" class="form-control" style="width: 200px; margin: 20px"
                       name="task_name" placeholder="Task Name"
                       required autofocus >
            </td>
        </tr>
        <tr>
            <td>Task Due Date:</td>
            <td class="long">
                <input type="text" class="form-control" style="width: 200px"
                       name="due_date" placeholder="yyyy-mm-dd"
                       required autofocus>
            </td>
        </tr>
    </table>

    <button class="button" type="submit" style="margin-top: 30px;"
            name="create_bonus_click">Create a task
    </button>

</form>


<p><a href='dashboard.php'>Back to Dashboard</a></p>
</body>
</html>
