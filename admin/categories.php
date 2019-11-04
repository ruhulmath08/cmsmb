<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}//only Admin can access this page
elseif (isset($_SESSION["username"]) && $_SESSION["role"] == "author") {
    header("Location: index.php");
}

$session_username = $_SESSION["username"];

//insert category
if (isset($_POST["submit"])) {
    $category_name = mysqli_real_escape_string($connectionDB, strtolower($_POST["categoryName"]));
    if (empty($category_name)) {
        $error_message = "Category field is empty!!!";
    } else {
        $category_date = time();
        $check_query = "SELECT * FROM categories WHERE category = '$category_name'";
        $check_run = mysqli_query($connectionDB, $check_query);
        if (mysqli_num_rows($check_run) > 0) {
            $error_message = "Category Already Exist!!!";
        } else {
            $insert_query = "INSERT INTO categories (category, date, addedby) VALUES ('$category_name', '$category_date', '$session_username')";
            //var_dump($insert_query);
            if (mysqli_query($connectionDB, $insert_query)) {
                $success_message = "Category Added Successfully!!!";
            } else {
                $error_message = "Something Wrong! Category has not been added!!!";
            }
        }
    }
}
//insert category

//Edit category
if (isset($_GET["edit"])) {
    $edit_id = $_GET["edit"];
}

//Edit => Update category
if (isset($_POST["update"])) {
    $category_update = mysqli_real_escape_string($connectionDB, strtolower($_POST["updateCategory"]));
    if (empty($category_update)) {
        $error_message = "Update field is empty!!!";
    } else {
        $category_date = time();
        $check_query = "SELECT * FROM categories WHERE category = '$category_update'";
        $check_run = mysqli_query($connectionDB, $check_query);
        if (mysqli_num_rows($check_run) > 0) {
            $error_message = "Updated category is already exist!!!";
        } else {
            $update_query = "UPDATE categories SET category = '$category_update' WHERE id = '$edit_id'";
            //var_dump($insert_query);
            if (mysqli_query($connectionDB, $update_query)) {
                $success_message = "Updated successfully!!!";
            } else {
                $error_message = "Something Wrong! Category has not been updated!!!";
            }
        }
    }
}
//Edit => Update category

//delete category
if (isset($_GET["del"])) {
    $del_id = $_GET["del"];

    if ($session_username && $_SESSION["role"] == "admin") {
        $del_query = "DELETE FROM categories WHERE id = '$del_id'";
        if (mysqli_query($connectionDB, $del_query)) {
            $success_message = "Category deleted successfully!!!";
        } else {
            $error_message = "Something Wrong! Category has not been deleted!!!";
        }
    }
}
//delete category

?>
</head>
<h3>Edit Category</h3>
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
                    <i class="fas fa-folder-open"></i> Categories
                    <small class="text-black-50">Different
                        Categories
                    </small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i>Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-folder-open"></i>Categories</li>
                </ol>

                <!-- Add and Update categories -->
                <div class="row">
                    <div class="col-md-6">
                        <h3>Add Category</h3>
                        <form action="" method="post" class="input-group">
                            <input type="text" class="form-control" placeholder="Category name"
                                   name="categoryName">
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <!-- form display when click edit button-->
                        <?php
                        if (isset($_GET["edit"])) {
                            $edit_check_query = "SELECT * FROM categories WHERE id = '$edit_id'";
                            $edit_check_run = mysqli_query($connectionDB, $edit_check_query);
                            if (mysqli_num_rows($edit_check_run) > 0) {
                                $edit_row = mysqli_fetch_array($edit_check_run);
                                $edit_category = $edit_row["category"];
                                ?>
                                <h3>Update Category</h3>
                                <form action="" method="post" class="input-group">
                                    <input type="text" class="form-control" placeholder="Update Category"
                                           name="updateCategory" value="<?php echo $edit_category; ?>">
                                    <div class="input-group-append">
                                        <input class="btn btn-primary" type="submit" name="update"
                                               value="Update Category">
                                    </div>
                                </form>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
                <!-- Add and Update categories -->

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

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th>Sr. #</th>
                            <th
                            ">Category Name</th>
                            <th>Create By</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $retrieve_query = "SELECT * FROM categories";
                        $retrieve_run = mysqli_query($connectionDB, $retrieve_query);
                        $seNo = 0;
                        if (mysqli_num_rows($retrieve_run) > 0) {
                            while ($dateRows = mysqli_fetch_array($retrieve_run)) {
                                $seNo++;
                                $retrieve_id = $dateRows["id"];
                                $retrieve_category = $dateRows["category"];
                                $retrieve_date = getdate($dateRows["date"]);
                                $day = $retrieve_date["mday"];
                                $month = $retrieve_date["month"];
                                $year = $retrieve_date["year"];
                                $retrieve_addedby = $dateRows["addedby"];
                                ?>
                                <tr>
                                    <td><?php echo $seNo; ?></td>
                                    <td class="text-left"><?php echo strtoupper($retrieve_category); ?></td>
                                    <td><?php echo $retrieve_addedby ?></td>
                                    <td><?php echo "$day $month $year" ?></td>
                                    <td>
                                        <a href="categories.php?edit=<?php echo $retrieve_id; ?>">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="categories.php?del=<?php echo $retrieve_id; ?>"
                                           onclick=" return myConfirm()">
                                            <i class=" fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<h3>No Categories Available!!!</h3>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!--Footer Section Start-->
    <?php include_once("include/footer.php"); ?>
    <!--Footer Section Ens-->
</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Prevent form resubmission when page is refreshed -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    //delete user
    function myConfirm() {
        let result = confirm("Are You sure? Want to delete this user?");
        if (result) {
            return true;
        } else {
            return false;
        }
    }
</script>
<!-- Prevent form resubmission when page is refreshed -->
</body>

</html>