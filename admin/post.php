<?php include_once("include/top.php"); ?>
<?php include_once "../inc/DB.php" ?>

<?php
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
/*We update this condition => Admin can access all but author can access only his/her posts*/
//only Admin can access this page
//elseif (isset($_SESSION["username"]) && $_SESSION["role"] == "author") {
//    header("Location: index.php");
//}

$session_username = $_SESSION["username"];
$session_user_image = $_SESSION["author_image"];

if (isset($_GET["del"])) {
    $del_id = $_GET["del"];

    //get id related image
    $query_for_image = "SELECT image from posts WHERE id = '$del_id'";
    $run_query_for_image = mysqli_query($connectionDB, $query_for_image);
    $row_image = mysqli_fetch_array($run_query_for_image);
    $delete_image_id = $row_image["image"];
    //get id related image

    //delete post
    if ($_SESSION["role"] == "admin") {
        $del_check_query = "SELECT * FROM posts WHERE id = '$del_id'";
        $del_check_run = mysqli_query($connectionDB, $del_check_query);
    } elseif ($_SESSION["role"] == "author") {
        $del_check_query = "SELECT * FROM posts WHERE id = '$del_id' AND author = '$session_username'";
        $del_check_run = mysqli_query($connectionDB, $del_check_query);
    }

    if (mysqli_num_rows($del_check_run) > 0) {
        $del_query = "DELETE FROM posts WHERE id = '$del_id'";
        if (mysqli_query($connectionDB, $del_query)) {
            $target_pate_to_delete_image = "uploads/blog/$delete_image_id";
            //var_dump($target_pate_to_delete_image);
            unlink($target_pate_to_delete_image);
            $success_message = "Post deleted successfully!!!";
        } else {
            $error_message = "Something wrong, post not deleted!!!";
        }
    } else {
        header("Location: index.php");
    }

    //delete post
}

/* For checkBox Bulk option Start */
if (isset($_POST["checkBoxes"])) {
    foreach ($_POST["checkBoxes"] as $postId) {
        $bulk_option = $_POST["bulk-options"];

        //get id related image
        $cb_query_for_image = "SELECT image from posts WHERE id = '$postId'";
        $cb_run_query_for_image = mysqli_query($connectionDB, $cb_query_for_image);
        $cb_row_image = mysqli_fetch_array($cb_run_query_for_image);
        $cb_delete_image_id = $cb_row_image["image"];
        $cb_target_pate_to_delete_image = "uploads/blog/$cb_delete_image_id";
        //get id related image

        if ($bulk_option == "delete") {
            $bulk_del_query = "DELETE FROM posts WHERE id = '$postId'";
            mysqli_query($connectionDB, $bulk_del_query);
            unlink($cb_target_pate_to_delete_image);
            unlink("../$cb_target_pate_to_delete_image");

        } elseif ($bulk_option == "publish") {
            $bulk_admin_query = "UPDATE posts SET status = 'publish' WHERE id = '$postId'";
            mysqli_query($connectionDB, $bulk_admin_query);

        } elseif ($bulk_option == "draft") {
            $bulk_admin_query = "UPDATE posts SET status = 'draft' WHERE id = '$postId'";
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
                    <i class="fas fa-file-alt"></i> Posts
                    <small class="text-black-50">View All Posts</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i> Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-file-alt"></i> Posts</li>
                </ol>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select name="bulk-options" id="" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="publish">Publish</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="submit" class="btn btn-success" value="Apply"
                                           onclick="return myConfirm();">
                                    <a href="addPost.php" class="btn btn-primary">Add New Post</a>
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
                    //admin can see all posts but author can see only his/her posts
                    if ($_SESSION["role"] == "admin") {
                        $query = "SELECT * FROM posts ORDER BY id DESC";
                        $run = mysqli_query($connectionDB, $query);
                    } elseif ($_SESSION["role"] == "author") {
                        $query = "SELECT * FROM posts WHERE author = '$session_username' ORDER BY id DESC";
                        $run = mysqli_query($connectionDB, $query);
                    }
                    if (mysqli_num_rows($run) > 0) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center">
                            <thead class="thead-dark">
                            <tr class="text-left">
                                <th><input type="checkbox" id="selectAllBoxes"></th>
                                <th>Sr#</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Categories</th>
                                <th>Image</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sr = 0;
                            while ($rData = mysqli_fetch_array($run)) {
                            $postId = $rData["id"];
                            $postData = getdate($rData["date"]);
                            $day = $postData["mday"];
                            $month = substr($postData["month"], 0, 3);
                            $year = substr($postData["year"], 2, 4);
                            $postTitle = $rData["title"];
                            $postAuthor = $rData["author"];
                            $postCategory = $rData["categories"];
                            $postImage = $rData["image"];
                            $postViews = $rData["views"];
                            $postStatus = $rData["status"];
                            $sr++;
                            ?>

                            <tr>
                                <th><input type="checkbox" class="checkBoxes" name="checkBoxes[]"
                                           value="<?php echo $postId; ?>"></th>
                                <td><?php echo $sr; ?></td>
                                <td><?php echo "$day-$month-$year"; ?></td>
                                <td class="text-left"> <?php echo $postTitle; ?></td>
                                <td> <?php echo $postAuthor; ?></td>
                                <td> <?php echo $postCategory; ?></td>
                                <td>
                                    <img src="uploads/blog/<?php echo $postImage; ?>" width="90px"
                                         alt="user image">
                                </td>
                                <td><?php echo $postViews; ?></td>
                                <td>
                                    <span class="<?php if ($postStatus == 'publish') {
                                        echo 'text-success';
                                    } else {
                                        echo 'text-danger';
                                    } ?>"><?php echo $postStatus; ?></span>
                                </td>
                                <td>
                                    <a href="editPost.php?edit=<?php echo $postId; ?>" target="_blank">
                                        <i class="fa fa-pencil-alt text-primary"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="post.php?del=<?php echo $postId; ?>" onclick=" return myConfirm();">
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