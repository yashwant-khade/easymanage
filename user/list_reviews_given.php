<!-- List of all reviews that this user has given. -->
<?php
require("../connection.php");
if (session_id() == "") {session_start();}
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
// ===================== SQL Queries Section =====================
$sql_query = "SELECT  perf_review.perf_id, perf_rating,  perf_review.receiver_wrk_id, wrk_name, year_id
FROM perf_review 	JOIN worker ON perf_review.receiver_wrk_id = wrk_id
					JOIN yearly_review ON yearly_review.perf_id = perf_review.perf_id
WHERE  perf_review.giver_wrk_id = $my_wrk_id
";
// ===================== SQL Queries Section =====================
$review_rows = array();
$statement    = $sql_query;
$result       = $conn->query($statement);
$numresults   = mysqli_num_rows($result);
if($numresults != 0) {
    while($numresults !=0) {
        $rows = $result->fetch_assoc();
        $review_rows[] = $rows;
        $numresults--;
    }
}
?>
<!DOCTYPE html>
<html>

<head >
    <meta charset="utf-8">
    <title>Performance Reviews Given</title>
    <link rel="stylesheet" href = "../stylesheets/user_list_style.css" >
    <style></style>
</head>

<body>
    <h1>Performance Reviews Given</h1>
    <?php
    if (!empty($review_rows)) {
    ?>
    <table>
        <tr>
            <th class="thin">ID</th>
            <th>Rating</th>
            <th>Recipient ID</th>
            <th>Recipient Name</th>
            <th class="thin">Year</th>
        </tr>
        <?php
        for ($i = 0; $i < count($review_rows); $i++) {
        ?>
        <tr>
            <td class="thin"><?php print $review_rows[$i]['perf_id']; ?></td>
            <td><?php print $review_rows[$i]['perf_rating']; ?></td>
            <td><?php print $review_rows[$i]['receiver_wrk_id']; ?></td>
            <td><?php print $review_rows[$i]['wrk_name']; ?></td>
            <td class="thin"><?php print $review_rows[$i]['year_id']; ?></td>
        </tr>
            <?php
        }
        ?>
    </table>
        <?php
    }
    else {
        ?>
        <p>You don't have any given reviews yet!</p>
        <?php
    }
    ?>
    <p><a href='dashboard.php'>Back to Dashboard</a></p>

</body>

</html>