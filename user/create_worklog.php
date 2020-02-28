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

$query1="SELECT task_id, proj_id, task_name
FROM task
WHERE assigned_emp_wrk_id = $my_wrk_id AND task_status != 'Abandoned' AND task_status != 'Completed';
";

if (isset($_POST['create_bonus_click'])) {

    $task_details = $_POST['task'];
    $entry_date = $_POST['worklog_date'];
    $description = $_POST['description'];
    $hours = $_POST['hours'];

    list($task_id, $proj_id) =
        explode(" ", $task_details, 2);

    if(is_numeric($task_id) && is_numeric($proj_id) && is_numeric($hours) && trim($description) != "" && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$entry_date)){
        $query4 = "INSERT INTO worklog(desp,entry_date,hours,proj_id,task_id)
                    VALUES('$description', '$entry_date', $hours, $proj_id, $task_id);
                    ";

        if ($conn->query($query4) === TRUE) {
            alert("Successfully added worklog!");
            myLogger('Added task to task table', 'CREATE WORKLOG','Success');
        } else {
            echo "Error: " . $query4 . "<br>" . $conn->error;
            myLogger('Added task to task table'.$conn->error, 'CREATE WORKLOG','Error');
        }
    }else
    {
        alert("Please enter valid data");
        myLogger('Data entered is not valid', 'CREATE WORKLOG','Warning');
    }
}


$result_users = $conn->query($query1);
if ($result_users->num_rows == 0) {
    echo "No Tasks Found";
    $loginShow='display: none';
    myLogger('Not authorized as no users in the dropdown', 'CREATE WORKLOG','Warning');

}else
{
    $loginShow = '';
    myLogger('Authorized and loaded data successfully', 'CREATE WORKLOG','Info');

}

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
            <td>Select Task:</td>
            <td class="long">
                <select class="select-css" name="task">
                    <?php
                    while ($row1 = mysqli_fetch_array($result_users)) {
                        echo "<option value='" . $row1['task_id'] .' '. $row1['proj_id']."'>" .$row1['task_id'].' - '. $row1['task_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Description:</td>
            <td class="long">
                <input type="text" class="form-control" style="width: 200px"
                       name="description" placeholder="Description"
                       required autofocus>
            </td>
        </tr>
        <tr>
            <td>Worklog Date:</td>
            <td class="long">
                <input type="text" class="form-control" style="width: 200px"
                       name="worklog_date" placeholder="yyyy-mm-dd"
                       required autofocus>
            </td>
        </tr>
        <tr>
            <td>Hours:</td>
            <td class="long">
                <select class="select-css" name="hours">
                    <?php
                    for ($x = 1; $x <= 9; $x++)  {
                        echo "<option value='" .$x. "'>" . $x . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <button class="button" type="submit" style="margin-top: 30px;"
            name="create_bonus_click">Add a worklog
    </button>

</form>


<p><a href='dashboard.php'>Back to Dashboard</a></p>
</body>
</html>
