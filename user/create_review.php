<?php require("../connection.php"); ?>
<?php require("../mylogger.php"); ?>

<?php

function alert()
{
    echo '<script type="text/javascript">alert("Successfully added review!");</script>';

}
session_start();
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
$my_position = $_SESSION['curr_user']['position'];

if ($my_position == "Department Head") {
    $query1 = "SELECT wrk_name, wrk_id
FROM worker
WHERE wrk_id != $my_wrk_id AND wrk_id IN 
	(SELECT emp_wrk_id
	FROM employee
	WHERE works_for_dept_name IN
(SELECT leads_dept_name 
FROM department_head
WHERE dh_wrk_id = $my_wrk_id));";
} else if ($my_position == "Director") {
    $query1 = "SELECT wrk_name, wrk_id
FROM worker;";
} else if ($my_position == "Manager") {
    $query1 = "SELECT wrk_name, wrk_id
FROM worker
WHERE wrk_id != $my_wrk_id AND wrk_id IN 
(SELECT emp_wrk_id
FROM employee_management
WHERE manager_wrk_id = $my_wrk_id);";
} else {
    $query1 = "";
}


if (isset($_POST['create_review_click'])) {

    $receiver_wrk_id = $_POST['worker_id'];
    $rating = $_POST['rating'];
    $this_year = $_POST['year'];


    $query4 = "INSERT INTO perf_review(receiver_wrk_id, giver_wrk_id, perf_rating) VALUES ($receiver_wrk_id, $my_wrk_id, $rating);
";

//    include ("connection.php");


    if ($conn->query($query4) === TRUE) {
        $perf_id = $conn->insert_id;
        $query5 = "INSERT INTO yearly_review(year_id, perf_id, receiver_wrk_id, giver_wrk_id)VALUES ($this_year, $perf_id, $receiver_wrk_id, $my_wrk_id);";
        myLogger('Added review to perf_review table', 'CREATE REVIEW','Success');

        if ($conn->query($query5) === TRUE) {
            alert();
            myLogger('Added review to yearly_review bonus', 'CREATE REVIEW','Success');

        } else {
            echo "Error: " . $query5 . "<br>" . $conn->error;
            myLogger('Added review to yearly_review table'.$conn->error, 'CREATE REVIEW','Error');

        }
    } else {
        echo "Error: " . $query4 . "<br>" . $conn->error;
        myLogger('Added review to perf_review table'.$conn->error, 'CREATE REVIEW','Error');

    }
}


if($query1 != ""){
    $result_users = $conn->query($query1);
    if ($result_users->num_rows == 0) {
        echo "Not Authorized";
        $loginShow='display: none';
        myLogger('Not authorized as no users in the dropdown', 'CREATE REVIEW','Warning');

    }else
    {
        myLogger('Authorized and loaded data successfully', 'CREATE REVIEW','Info');

        $loginShow = '';
    }
}else
{
    echo "Not Authorized";
    $loginShow='display: none';
    myLogger('Not authorized as you are a employee', 'CREATE REVIEW','Warning');

}

$query2 = "SELECT * FROM year ORDER BY year_id desc ";
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
            <td>Select Emloyee:</td>
            <td class="long">
                <select class="select-css" name="worker_id">
                    <?php
                    while ($row = mysqli_fetch_array($result_users)) {
                        echo "<option value='" . $row['wrk_id'] . "'>" . $row['wrk_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Select Rating:</td>
            <td class="long">
               <select class="select-css" name="rating">
                    <?php
                    for ($x = 1; $x <= 5; $x++)  {
                        echo "<option value='" .$x. "'>" . $x . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Select Year:</td>
            <td class="long">
                <select class="select-css" name="year">
                    <?php
                    while ($row1 = mysqli_fetch_array($result_years)) {
                        echo "<option value='" . $row1['year_id'] . "'>" . $row1['year_id'] . "</option>";
                    }
                    ?></select>
            </td>
        </tr>
    </table>

    <button class="button" type="submit" style="margin-top: 30px;"
            name="create_review_click">Give a review
    </button>

</form>


<p><a href='dashboard.php'>Back to Dashboard</a></p>
</body>
</html>
