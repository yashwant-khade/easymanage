<!-- Public list of all users. (Do NOT list passwords, for obvious reasons.) -->
<?php
require("../connection.php");
if (session_id() == "") {
    session_start();
}
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
// ===================== SQL Queries Section =====================
$sql_query = "select wrk.wrk_id, wrk.wrk_name, wrk.starting_year_id from worker as wrk
order by wrk.wrk_id ASC;
";
// ===================== SQL Queries Section =====================
$worker_rows = array();
$statement = $sql_query;
$result = $conn->query($statement);
$numresults = mysqli_num_rows($result);
if ($numresults != 0) {
    while ($numresults != 0) {
        $rows = $result->fetch_assoc();
        $worker_rows[] = $rows;
        $numresults--;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>All Personnel</title>
    <link rel="stylesheet" href="../stylesheets/user_list_style.css">
    <style></style>
</head>

<body>
<h1>All Personnel</h1>
<?php
if (!empty($worker_rows)) {
    ?>
    <table>
        <tr>
            <th class="thin">ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Department</th>
            <th class="thin">Starting Year</th>
        </tr>
        <?php
        for ($i = 0; $i < count($worker_rows); $i++) {
            ?>
            <tr>
                <td class="thin"><?php print $worker_rows[$i]['wrk_id']; ?></td>
                <td><?php print $worker_rows[$i]['wrk_name']; ?></td>
                <?php
                $each_wrk_id = $worker_rows[$i]['wrk_id'];
                $query1 = "(SELECT 'Department Head' as position, leads_dept_name as department FROM department_head WHERE dh_wrk_id = $each_wrk_id) 
                            UNION 
                            (SELECT 'Director', 'N/A' FROM director WHERE director_wrk_id = $each_wrk_id) 
                            UNION 
                            (SELECT 'Manager', works_for_dept_name FROM manager JOIN employee ON emp_wrk_id = manager_wrk_id WHERE manager_wrk_id = $each_wrk_id AND NOT EXISTS 
                            (SELECT * FROM department_head WHERE dh_wrk_id = $each_wrk_id)) 
                            UNION
                            (SELECT 'Employee', works_for_dept_name FROM employee WHERE emp_wrk_id = $each_wrk_id AND NOT EXISTS 
                            (SELECT * FROM manager WHERE manager_wrk_id = $each_wrk_id));
                            ";
                $result_users = $conn->query($query1);
                while ($row1 = mysqli_fetch_array($result_users)) {
                    echo "<td>" . $row1['position'] . "</td>";
                    echo "<td>" . $row1['department'] . "</td>";
                }
                ?>
                <td class="thin"><?php print $worker_rows[$i]['starting_year_id']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <p>You don't have any bonuses yet!</p>
    <?php
}
?>
<p><a href='dashboard.php'>Back to Dashboard</a></p>

</body>

</html>