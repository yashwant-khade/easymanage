<?php require("../connection.php"); ?>
<?php require("../mylogger.php"); ?>
<?php
$loginShow='';
function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";

}
session_start();
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
$my_position = $_SESSION['curr_user']['position'];

$query1="SELECT wrk_name, manager_wrk_id
		FROM worker JOIN manager ON manager_wrk_id = wrk_id
    					JOIN employee ON emp_wrk_id = wrk_id
		WHERE works_for_dept_name = 
(SELECT leads_dept_name
FROM department_head
WHERE dh_wrk_id = $my_wrk_id);
";
if (isset($_POST['create_review_click']) ) {

    $manager_wrk_id = $_POST['worker_id'];
    $project_due_date = $_POST['deadline'];
    $project_status='Not Started';
    $project_name=$_POST['project_name'];

   if(is_numeric($manager_wrk_id) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$project_due_date) && $project_status!="" && trim($project_name)!=""){
       $query4 = "INSERT INTO project(proj_name, proj_due_date, proj_status, supervisor_dh_wrk_id)
	VALUES('$project_name', '$project_due_date', '$project_status', $my_wrk_id);       
";

//    include ("connection.php");


       if ($conn->query($query4) === TRUE) {
           $project_id = $conn->insert_id;
           $query5 = "INSERT INTO proj_management(proj_id, manager_wrk_id)
                    VALUES($project_id, $manager_wrk_id)  
                    ";
           myLogger('Added project to project table', 'CREATE PROJECT','Success');
           if ($conn->query($query5) === TRUE) {
               alert("Successfully added project");
               myLogger('Added project to proj_management', 'CREATE PROJECT','Success');

           } else {
               echo "Error: " . $query5 . "<br>" . $conn->error;
               myLogger('Added project to yearly proj_management table'.$conn->error, 'CREATE PROJECT','Error');
           }
       } else {
           echo "Error: " . $query4 . "<br>" . $conn->error;
           myLogger('Added project to yearly project table'.$conn->error, 'CREATE PROJECT','Error');

       }
   }else{
       alert("Please enter valid data");
       myLogger('Tried to enter non valid data', 'CREATE PROJECT','Warning');

   }
}


$result_users = $conn->query($query1);
if ($result_users->num_rows == 0) {
    echo "Not Authorized";
    $loginShow='display: none';
    myLogger('Not authorized as no users in the dropdown', 'CREATE PROJECT','Warning');

}else
{
    myLogger('Authorized and loaded data successfully', 'CREATE PROJECT','Info');

    $loginShow = '';
}
$query2 = "SELECT * FROM year ORDER BY year_id desc ";
$result_years = $conn->query($query2);
//print_r($result_years);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add An Admin</title>
    <link rel="stylesheet" href="../stylesheets/create_style.css">
    <style></style>
</head>
<body >

<table class="create">
    <tr>
        <td>

<form method="post"
      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
      ?>" style="<?php echo $loginShow?>">

    Select Manager:
</td>
        <td class="long">
            <select class="select-css" name="worker_id">
                <?php
                while ($row = mysqli_fetch_array($result_users)) {
                    echo "<option value='" . $row['manager_wrk_id'] . "'>" . $row['wrk_name'] . "</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Project Name:</td>
        <td class="long">
            <input type="text" class="form-control" style="width: 200px"
                                name="project_name" placeholder="Project Name"
                                required autofocus>
        </td>
    </tr>
    <tr>
        <td>Deadline:</td>
        <td class="long">
            <input type="text" class="form-control" style="width: 200px"
                   name="deadline" placeholder="yyyy-mm-dd"
                   required autofocus>
        </td>
    </tr>
</table>





    <button class="button" type="submit" style="margin-top: 30px;"
            name="create_review_click">Create a project
    </button>

</form>


<p><a href='dashboard.php'>Back to Dashboard</a></p>
</body>
</html>
