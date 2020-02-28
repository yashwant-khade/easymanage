<!-- List of all bonuses that this user has received. -->
<?php
require("../connection.php");
if (session_id() == "") {
    session_start();
}
$my_wrk_id = $_SESSION['curr_user']['wrk_id'];
// ===================== SQL Queries Section =====================
$sql_query = "SELECT  bonus.bonus_id, bonus.amount,  bonus.giver_wrk_id, wrk_name, year_id
FROM  bonus JOIN worker ON giver_wrk_id = wrk_id
		JOIN yearly_bonus ON yearly_bonus.bonus_id = bonus.bonus_id
WHERE bonus.receiver_wrk_id = $my_wrk_id;
";
// ===================== SQL Queries Section =====================
$bonus_rows = array();
$statement = $sql_query;
$result = $conn->query($statement);
$numresults = mysqli_num_rows($result);
if ($numresults != 0) {
    while ($numresults != 0) {
        $rows = $result->fetch_assoc();
        $bonus_rows[] = $rows;
        $numresults--;
    }
}
?>
<!DOCTYPE html>
<html>

<head >
    <meta charset="utf-8">
    <title>Bonuses Received</title>
    <link rel="stylesheet" href = "../stylesheets/user_list_style.css" >
    <style></style>
</head>

<body>
    <h1>Bonuses Received</h1>
    <?php
    if (!empty($bonus_rows)) {
    ?>
    <table>
        <tr>
            <th class="thin">ID</th>
            <th>Amount</th>
            <th>Giver ID</th>
            <th>Giver Name</th>
            <th class="thin">Year</th>
        </tr>
        <?php
        for ($i = 0; $i < count($bonus_rows); $i++) {
        ?>
        <tr>
            <td class="thin"><?php print $bonus_rows[$i]['bonus_id']; ?></td>
            <td><?php print $bonus_rows[$i]['amount']; ?></td>
            <td><?php print $bonus_rows[$i]['giver_wrk_id']; ?></td>
            <td><?php print $bonus_rows[$i]['wrk_name']; ?></td>
            <td class="thin"><?php print $bonus_rows[$i]['year_id']; ?></td>
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