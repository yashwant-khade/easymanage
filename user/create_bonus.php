<?php require("../connection.php"); ?>
<?php require("../mylogger.php"); ?>

<?php
$loginShow= '';
session_start();
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
$my_position = $_SESSION['curr_user']['position'];
function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";

}

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


if (isset($_POST['create_bonus_click'])) {

    $receiver_wrk_id = $_POST['worker_id'];
    $amount = $_POST['amount'];
    $this_year = $_POST['year'];


    if(is_numeric($receiver_wrk_id) && trim($amount) != "" ){
        $query4 = "INSERT INTO bonus(amount, giver_wrk_id, receiver_wrk_id) VALUES ($amount, $my_wrk_id, $receiver_wrk_id);";

//    include ("connection.php");


        if ($conn->query($query4) === TRUE) {
            $bonus_id = $conn->insert_id;
            $query5 = "INSERT INTO yearly_bonus(year_id, bonus_id, giver_wrk_id, receiver_wrk_id) VALUES ($this_year, $bonus_id, $my_wrk_id, $receiver_wrk_id);";
            myLogger('Added bonus to bonus table', 'CREATE BONUS','Success');

            if ($conn->query($query5) === TRUE) {
                alert("Successfully added bonus!");
                myLogger('Added bonus to yearly bonus', 'CREATE BONUS','Success');
            } else {
                echo "Error: " . $query5 . "<br>" . $conn->error;
                myLogger('Unable to Add bonus to yearly bonus table'.$conn->error, 'CREATE BONUS','Error');

            }
        } else {
            echo "Error: " . $query4 . "<br>" . $conn->error;
            myLogger('Unable to Add bonus to bonus table'.$conn->error, 'CREATE BONUS','Error');

        }
    }else
    {
        alert("Please enter valid data");
        myLogger('Tried to enter non valid data', 'CREATE BONUS','Warning');
    }
}

if($query1 != ""){
    $result_users = $conn->query($query1);
    if ($result_users->num_rows == 0) {
        echo "Not Authorized";
        $loginShow='display: none';
        myLogger('Not authorized as no users in the dropdown', 'CREATE BONUS','Warning');

    }else
    {
        myLogger('Authorized and loaded data successfully', 'CREATE BONUS','Info');
        $loginShow = '';
    }
}else
{
    echo "Not Authorized";
    $loginShow='display: none';
    myLogger('Not authorized as you are a employee', 'CREATE BONUS','Warning');
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

<p style=""></p>

<form method="post"
      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
      ?>" style="<?php echo $loginShow?>">


    <table class="create">
        <tr>
            <td>
                Select Employee:
            </td>
            <td class="long"><select class="select-css" name="worker_id" ><?php
                    while ($row = mysqli_fetch_array($result_users)) {
                        echo "<option value='" . $row['wrk_id'] . "'>" . $row['wrk_name'] . "</option>";
                    }
                    ?></select></td>
        </tr>
        <tr>
            <td>
                Amount:
            </td>
            <td class="long">
                <input type="text" class="form-control" style="width: 200px"
                       name="amount" placeholder="0"
                       required autofocus>
            </td>
        </tr>
        <tr>
            <td>Select Year:</td>
            <td class="long" style="padding-left: 10px;"><select class="select-css" name="year" style="margin: 10px;"><?php
                    while ($row1 = mysqli_fetch_array($result_years)) {
                        echo "<option value='" . $row1['year_id'] . "'>" . $row1['year_id'] . "</option>";
                    }
                    ?></select></td>
        </tr>
    </table>


    <br/>


    <!--    <input type="text" class="form-control" style="width: 200px"-->
    <!--           name="year" placeholder="Year"-->
    <!--           required autofocus></br>-->

   <br/>
    <button class="button" type="submit" style="margin-top: 30px;"
            name="create_bonus_click">Give a bonus
    </button>

</form>


<p><a href='dashboard.php'>Back to Dashboard</a></p>
</body>
</html>
