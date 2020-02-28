<?php
$searchStr='';
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

</head>
<body>



<div id="">
    <div class="">
        <h3>Search Users</h3>
        <div class="row " id="" style="margin-right: 0; margin-left: 0;">
            <form class="form-group" role="form"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                  ?>" method="post">


                <input type="text" class="form-control" style="width: 250px" value="<?php echo $searchStr;?>"
                       name="searchUser" placeholder="ID, Name, Starting Year" required></br>

                <button class="btn btn-default" type="submit" style="margin-top: 30px;"
                        name="searchusr">Search User
                </button>

            </form>

            <?php
            if (isset($_POST['searchusr'])){
            include("connection.php");
            $searchStr = $_POST['searchUser'];
            $result = $conn->query("select * from EasyManage where wrk_name like '%$searchStr%'");
            ?>
            <table style="width:70%" align="center">
                <tr style="background-color:#1da1f2; color:white; height:50px; border: 1px solid green">
                    <th style="background-color:#1da1f2; height:50px; color:white; align:center; border: 1px solid black;padding: 5px;">
                        Worker ID
                    </th>
                    <th style="background-color:#1da1f2; height:50px; color:white; align:center;  border: 1px solid black;padding: 5px;">
                        Name
                    </th>
                    <th style="background-color:#1da1f2; height:50px; color:white; align:center;  border: 1px solid black;padding: 5px;">
                        Starting Year
                    </th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr style="background-color:white; width:auto; color:black;">
                        <td style="background-color:white; width:auto; color:black; border: 1px solid black;padding: 5px;">
                            <?php
                            print $row['wrk_id'];
                            ?>
                        </td>
                        <td style="background-color:white; width:auto; color:black; border: 1px solid black;padding: 5px;">
                            <?php
                            print $row['wrk_name'];
                            ?>
                        </td>
                        <td style="background-color:white; width:auto; color:black; border: 1px solid black;padding: 5px;">
                            <?php
                            print $row['starting_year_id'];
                            ?>
                        </td>
                    </tr>
                    <?php
                }

                }
                ?>

            </table>
        </div>
    </div>
</div>


</body>
</html>
