<?php
    require("../connection.php");
    if (session_id() == "") {session_start();}
    if (!isset($_SESSION['user_loggedIn'])) {
        $wrk_id   = $_POST['wrk_id'];
        $password = $_POST['password'];

        // ===================== SQL Queries Section =====================
        $sql_query1 = "SELECT * FROM worker
                       WHERE wrk_id = $wrk_id AND password=PASSWORD('$password')";

        // NEED TO DOUBLE CHECK IN QUERIES LATER, NOT SHOWING per_year
        $sql_query2 = "(SELECT annual_salary, 'per year'
                        FROM salary_work WHERE wrk_id = $wrk_id)
                        UNION (SELECT hourly_salary, 'per hour'
                        FROM hourly_work WHERE wrk_id = $wrk_id)";

        $sql_query3 = "(SELECT 'Department Head' as position, leads_dept_name
                        AS department FROM department_head
                        WHERE dh_wrk_id = $wrk_id) UNION

                        (SELECT 'Director', 'N/A' FROM director
                        WHERE director_wrk_id = $wrk_id) UNION 
                        (SELECT 'Manager', works_for_dept_name
                        FROM manager JOIN employee ON emp_wrk_id = manager_wrk_id
                        WHERE manager_wrk_id = $wrk_id AND NOT EXISTS 
                        (SELECT * FROM department_head
                        WHERE dh_wrk_id = $wrk_id)) UNION 
                        (SELECT 'Employee', works_for_dept_name FROM employee
                        WHERE emp_wrk_id = $wrk_id AND NOT EXISTS
                        (SELECT * FROM manager WHERE manager_wrk_id = $wrk_id));";
        // ===================== SQL Queries Section =====================

        // Commit Testing
        // commit complete

        // This section will retrieving data needed for currently logged in user,
        // and store it in $_SESSION['curr_user']

        // It will have following attributes:
        // wrk_id, wrk_name, position, department, annual_salary, starting_year_id, user_loggedIn

        // user_loggedIn flag will also be set in $_SESSION['user_loggedIn']
        $_SESSION['curr_user'] = array();

        $statement1 = $sql_query1;
        $result1 = $conn->query($statement1);
        $numresults1 = mysqli_num_rows($result1);
        if($numresults1 != 1) {
            die(header("Location: user_login.php"));
        }
        $rows1 = $result1->fetch_assoc();
        $_SESSION['curr_user'] = $rows1;

        $statement2 = $sql_query2;
        $result2 = $conn->query($statement2);
        $numresults2 = mysqli_num_rows($result2);
        if ($numresults2 == 1) {
            $rows2 = $result2->fetch_assoc();
            $_SESSION['curr_user']['annual_salary'] = $rows2['annual_salary'];
            $_SESSION['curr_user']['per_year']    = $rows2['per year'];
            //print $_SESSION['current_user']['per year'];

            $statement3 = $sql_query3;
            $result3 = $conn->query($statement3);
            $numresults3 = mysqli_num_rows($result3);
            if ($numresults3 == 1) {}
            $rows3 = $result3->fetch_assoc();
            $_SESSION['curr_user']['position']   = $rows3['position'];
            $_SESSION['curr_user']['department'] = $rows3['department'];
            $_SESSION['user_loggedIn']   = true;
        }
    }
?>

<!DOCTYPE html>
<html>
<head >
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href = "../stylesheets/dashboard_style.css" >
    <style></style>
</head>
<body style="background-color: #1C63DC;">
    <h1><?php print $_SESSION['curr_user']['wrk_name'];?>'s Dashboard</h1>
    <div class="white-box" id="personal-info">
        <h2>My Information</h2>
        <ul class="bullet">
            <li>ID Number: <?php print $_SESSION['curr_user']['wrk_id'];?></li>
            <li>Position: <?php print $_SESSION['curr_user']['position'];?></li>
            <li>Department: <?php print $_SESSION['curr_user']['department']?></li>
            <li>Salary: <?php print "$".number_format($_SESSION['curr_user']['annual_salary'])."/".$_SESSION['curr_user']['per_year'];?></li>
            <li>Starting Year: <?php print $_SESSION['curr_user']['starting_year_id'];?></li>
        </ul>
    </div>
    <div id="column-holder">
        <div class ="white-box" id="left-column">
            <h2>Projects</h2>
            <ul>
                <li><a href="list_my_projects.php">My Projects</a></li>
                <li><a href="create_project.php">Create a New Project</a></li>
                <li><a href="list_assigned_projects.php">Projects Assigned to Me</a></li>
            </ul>
        </div>
        <div class ="white-box" id="middle-column">
            <h2>Tasks</h2>
            <ul>
                <li><a href="list_my_tasks.php">My Tasks</a></li>
                <li><a href="create_task.php">Create a New Task</a></li>
                <li><a href="list_assigned_tasks.php">Tasks Assigned to Me</a></li>
            </ul>
        </div>
        <div class ="white-box" id="right-column">
            <h2>Work Logs</h2>
            <ul>
                <li><a href="list_my_worklogs.php">My Worklogs</a></li>
                <li><a href="create_worklog.php">Create a Worklog</a></li>
            </ul>
        </div>
    </div>
    <div id="column-holder">
        <div class ="white-box" id="left-column">
            <h2>Personnel</h2>
            <ul>
                <li><a href="list_all_personnel.php">All Personnel</a></li>
            </ul>
        </div>
        <div class ="white-box" id="middle-column">
            <h2>Bonuses</h2>
            <ul>
                <li><a href="list_bonuses_given.php">Bonuses Given</a></li>
                <li><a href="create_bonus.php">Give a New Bonus</a></li>
                <li><a href="list_bonuses_received.php">Bonuses Received</a></li>
            </ul>
        </div>
        <div class ="white-box" id="right-column">
            <h2>Reviews</h2>
            <ul>
                <li><a href="list_reviews_given.php">Reviews Given</a></li>
                <li><a href="create_review.php">Give a New Review</a></li>
                <li><a href="list_reviews_received.php">Reviews Received</a></li>
            </ul>
        </div>
    </div>
    <!-- <p><a class="home" href='../index.php'>Back to Homepage</a></p> -->
    <form method="post" action="../administrative/prcs/prcs_signout.php">
        <button style="display: block; height: 100%; max-width: 200px; padding: 15px 25px; font-size: 24px; background-color: #34548B; color: #f2f2f2; vertical-align: bottom;"
                class="button" name="username" type="submit" value="">Logout</button>
    </form>
    <br><br>
</body>
</html>
