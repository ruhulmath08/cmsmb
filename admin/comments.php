<?php include_once("include/top.php"); ?>
<?php include_once "../inc/DB.php" ?>

<?php
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
} //only Admin can access this page
elseif (isset($_SESSION["username"]) && $_SESSION["role"] == "author") {
    header("Location: index.php");
}

//delete comment
if (isset($_GET["del"])) {
    $del_id = $_GET["del"];
    //check for valid id
    $del_check_query = "SELECT * FROM comments WHERE id = '$del_id'";
    $del_check_run = mysqli_query($connectionDB, $del_check_query);
    if (mysqli_num_rows($del_check_run) > 0) {
        $del_query = "DELETE FROM comments WHERE id = '$del_id'";
        //only admin can delete user
        if (isset($_SESSION["username"]) && $_SESSION["role"] == "admin") {
            if (mysqli_query($connectionDB, $del_query)) {
                $success_message = "Comment deleted successfully!!!";
            } else {
                $error_message = "Something wrong, comment not deleted!!!";
            }
        }
    } else {
        header("Location: index.php");
    }
}
//delete comment

//approve comment
if (isset($_GET["approve"])) {
    $approve_id = $_GET["approve"];
    //check for valid id
    $approve_check_query = "SELECT * FROM comments WHERE id = '$approve_id'";
    $approve_check_run = mysqli_query($connectionDB, $approve_check_query);
    if (mysqli_num_rows($approve_check_run) > 0) {
        $approve_query = "UPDATE comments SET status = 'approve' WHERE id = '$approve_id'";
        //only admin can delete user
        if (isset($_SESSION["username"]) && $_SESSION["role"] == "admin") {
            if (mysqli_query($connectionDB, $approve_query)) {
                $success_message = "Comment approve successfully!!!";
            } else {
                $error_message = "Something wrong, comment not approve!!!";
            }
        }
    } else {
        header("Location: index.php");
    }
}
//approve comment

//UnApprove comment
if (isset($_GET["unapprove"])) {
    $unapprove_id = $_GET["unapprove"];
    //check for valid id
    $unapprove_check_query = "SELECT * FROM comments WHERE id = '$unapprove_id'";
    $unapprove_check_run = mysqli_query($connectionDB, $unapprove_check_query);
    if (mysqli_num_rows($unapprove_check_run) > 0) {
        $unapprove_query = "UPDATE comments SET status = 'pending' WHERE id = '$unapprove_id'";
        //only admin can delete user
        if (isset($_SESSION["username"]) && $_SESSION["role"] == "admin") {
            if (mysqli_query($connectionDB, $unapprove_query)) {
                $success_message = "Comment unapprove successfully!!!";
            } else {
                $error_message = "Something wrong, comment not unapprove!!!";
            }
        }
    } else {
        header("Location: index.php");
    }
}
//UnApprove comment


/* For checkBox Bulk option Start */
if (isset($_POST["checkBoxes"])) {
    foreach ($_POST["checkBoxes"] as $userId) {
        $bulk_option = $_POST["bulk-options"];

        if ($bulk_option == "delete") {
            $bulk_del_query = "DELETE FROM comments WHERE id = '$userId'";
            mysqli_query($connectionDB, $bulk_del_query);

        } elseif ($bulk_option == "approve") {
            $bulk_admin_query = "UPDATE comments SET status = 'approve' WHERE id = '$userId'";
            mysqli_query($connectionDB, $bulk_admin_query);

        } elseif ($bulk_option == "pending") {
            $bulk_admin_query = "UPDATE comments SET status = 'pending' WHERE id = '$userId'";
            mysqli_query($connectionDB, $bulk_admin_query);
        }
    }
}
/* For checkBox Bulk option End */
?>
</head>

<body>
<div id="wrapper">
    <!-- NavBar Start-->
    <?php include_once("include/header.php"); ?>
    <!-- NavBar End-->

    <div class="container-fluid body-section mt-3">
        <div class="row">
            <div class="col-md-3">
                <?php include_once("include/sidebar.php"); ?>
            </div>
            <div class="col-md-9">
                <h1>
                    <i class="fas fa-comments"></i> Comments
                    <small class="text-black-50">View All Comments</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i>Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-comments"></i>Comments</li>
                </ol>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select name="bulk-options" id="" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="approve">Approve</option>
                                            <option value="pending">Unapprove</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="submit" class="btn btn-success" value="Apply"
                                           onclick="return myConfirm();">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <!-- display message-->
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger alert-dismissible'>
                            <a href='#'class='close' data-dismiss='alert' aria-label='close'>&times;</a>$error_message
                            </div>";
                    } else if (isset($success_message)) {
                        echo "<div class='alert alert-success alert-dismissible'>
                            <a href='#'class='close' data-dismiss='alert' aria-label='close'>&times;</a>$success_message
                            </div>";
                    }
                    ?>
                    <!-- display message-->

                    <?php
                    $query = "SELECT id, date, username, comment, status, post_id FROM comments ORDER BY id DESC";
                    $run = mysqli_query($connectionDB, $query);
                    if (mysqli_num_rows($run) > 0) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center">
                            <thead class="thead-dark">
                            <tr class="text-left">
                                <th><input type="checkbox" id="selectAllBoxes"></th>
                                <th> Sr#</th>
                                <th> Date</th>
                                <th> User Name</th>
                                <th> Comment</th>
                                <th> Status</th>
                                <th> Approve</th>
                                <th> Unapprove</th>
                                <th> Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sr = 0;
                            while ($rData = mysqli_fetch_array($run)) {
                            $sr++;
                            $userId = $rData["id"];
                            $userData = getdate($rData["date"]);
                            $day = $userData["mday"];
                            $month = substr($userData["month"], 0, 3);
                            $year = substr($userData["year"], 2, 4);
                            $userUserName = $rData["username"];
                            $userComments = $rData["comment"];
                            $userStatus = $rData["status"];
                            $userPostId = $rData["post_id"];
                            ?>

                            <tr>
                                <th><input type="checkbox" class="checkBoxes" name="checkBoxes[]"
                                           value="<?php echo $userId; ?>"></th>
                                <td><?php echo $sr; ?></td>
                                <td><?php echo "$day-$month-$year"; ?></td>
                                <td> <?php echo $userUserName; ?></td>
                                <td class="text-justify"><?php echo $userComments; ?></td>
                                <td>
                                    <span class="<?php if ($userStatus == 'approve') {
                                        echo 'text-primary';
                                    } else {
                                        echo 'text-danger';
                                    } ?>"><?php echo $userStatus; ?></span>
                                </td>
                                <td>
                                    <a href="comments.php?approve=<?php echo $userId; ?>">
                                        <i class="fa fa-check text-success"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="comments.php?unapprove=<?php echo $userId; ?>">
                                        <i class="fas fa-times text-warning"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="comments.php?del=<?php echo $userId; ?>" onclick=" return myConfirm();">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                                <?php } ?>
                            </tbody>
                        </table>
                </form>
            </div>
            <?php
            } else {
                echo "<h1 class='text-center'>No User Available...</h1>";
            }
            ?>

        </div>
    </div>
</div>

<!--Footer Section Start-->
<?php include_once("include/footer.php"); ?>
<!--Footer Section Ens-->
<script language="JavaScript" type="text/javascript">
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    //confirm operation delete, approve, unapprove
    function myConfirm() {
        const result = confirm("Are You sure? Want to continue this operation?");
        if (result) {
            return true;
        } else {
            return false;
        }
    }
</script>
</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>