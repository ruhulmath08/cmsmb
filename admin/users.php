<?php include_once("include/top.php"); ?>
<?php include_once "../inc/DB.php" ?>

<?php
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
} //only Admin can access this page
elseif (isset($_SESSION["username"]) && $_SESSION["role"] == "author") {
    header("Location: index.php");
}

if (isset($_GET["del"])) {
    $del_id = $_GET["del"];

    //get id related image
    $query_for_image = "SELECT image from users WHERE id = '$del_id'";
    $run_query_for_image = mysqli_query($connectionDB, $query_for_image);
    $row_image = mysqli_fetch_array($run_query_for_image);
    $delete_image_id = $row_image["image"];
    //get id related image

    $del_query = "DELETE FROM users WHERE id = '$del_id'";
    //only admin can delete user
    if (isset($_SESSION["username"]) && $_SESSION["role"] == "admin") {
        if (mysqli_query($connectionDB, $del_query)) {
            $target_pate_to_delete_image = "uploads/authoradmin/$delete_image_id";
            unlink($target_pate_to_delete_image);
            unlink("../$target_pate_to_delete_image");
            $success_message = "User deleted successfully!!!";
        } else {
            $error_message = "Something wrong, user not deleted!!!";
        }
    }
}

/* For checkBox Bulk option Start */
if (isset($_POST["checkBoxes"])) {
    foreach ($_POST["checkBoxes"] as $userId) {
        $bulk_option = $_POST["bulk-options"];

        //get id related image
        $cb_query_for_image = "SELECT image from users WHERE id = '$userId'";
        $cb_run_query_for_image = mysqli_query($connectionDB, $cb_query_for_image);
        $cb_row_image = mysqli_fetch_array($cb_run_query_for_image);
        $cb_delete_image_id = $cb_row_image["image"];
        $cb_target_pate_to_delete_image = "uploads/authoradmin/$cb_delete_image_id";
        //get id related image

        if ($bulk_option == "delete") {
            $bulk_del_query = "DELETE FROM users WHERE id = '$userId'";
            mysqli_query($connectionDB, $bulk_del_query);
            unlink($cb_target_pate_to_delete_image);
            unlink("../$cb_target_pate_to_delete_image");

        } elseif ($bulk_option == "author") {
            $bulk_admin_query = "UPDATE users SET role = 'author' WHERE id = '$userId'";
            mysqli_query($connectionDB, $bulk_admin_query);

        } elseif ($bulk_option == "admin") {
            $bulk_admin_query = "UPDATE users SET role = 'admin' WHERE id = '$userId'";
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
                    <i class="fas fa-users"></i> Users
                    <small class="text-black-50">View All Users</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i>Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-folder-open"></i>Users</li>
                </ol>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select name="bulk-options" id="" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="author">Change to Author</option>
                                            <option value="admin">Change to Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="submit" class="btn btn-success" value="Apply"
                                           onclick="return myConfirm();">
                                    <a href="addUser.php" class="btn btn-primary">Add New</a>
                                </div>
                            </div>

                        </div>
                    </div>

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

                    <hr/>
                    <?php
                    $query = "SELECT * FROM users ORDER BY id DESC";
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
                                <th> Name</th>
                                <th> Email</th>
                                <th> Image</th>
                                <th> Password</th>
                                <th> Role</th>
                                <th> Edit</th>
                                <th> Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sr = 0;
                            while ($rData = mysqli_fetch_array($run)) {
                            $userId = $rData["id"];
                            $userData = getdate($rData["date"]);
                            $day = $userData["mday"];
                            $month = substr($userData["month"], 0, 3);
                            $year = substr($userData["year"], 2, 4);
                            $userFirstName = ucfirst($rData["first_name"]);
                            $userLastName = ucfirst($rData["last_name"]);
                            $userUserName = $rData["username"];
                            $userEmail = $rData["email"];
                            $userImage = $rData["image"];
                            $userRole = $rData["role"];
                            $sr++;
                            ?>

                            <tr>
                                <th><input type="checkbox" class="checkBoxes" name="checkBoxes[]"
                                           value="<?php echo $userId; ?>"></th>
                                <td><?php echo $sr; ?></td>
                                <td><?php echo "$day-$month-$year"; ?></td>
                                <td> <?php echo $userUserName ?></td>
                                <td> <?php echo "$userFirstName $userLastName"; ?></td>
                                <td> <?php echo $userEmail ?></td>
                                <td><img class="rounded-circle" src="uploads/authoradmin/<?php echo $userImage ?>"
                                         width="30px"
                                         alt="user image"></td>
                                <td>*********</td>
                                <td><?php echo ucfirst($userRole); ?></td>
                                <td>
                                    <a href="editUser.php?edit=<?php echo $userId; ?>">
                                        <i class="fa fa-pencil-alt text-primary"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="users.php?del=<?php echo $userId; ?>" onclick=" return myConfirm();">
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

    //delete user
    function myConfirm() {
        var result = confirm("Are You sure? Want to delete this user?");
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