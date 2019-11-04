<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
} //only Admin can access this page
elseif (isset($_SESSION["username"]) && $_SESSION["role"] == "author") {
    header("Location: index.php");
}

//get ID comes throw URL
if (isset($_GET["edit"])) {
    $edit_id = $_GET["edit"];
    $edit_query = "SELECT * FROM users WHERE id = '$edit_id'";
    $edit_query_run = mysqli_query($connectionDB, $edit_query);
    if (mysqli_num_rows($edit_query_run) > 0) {
        $edit_row = mysqli_fetch_array($edit_query_run);
        $e_first_name = $edit_row["first_name"];
        $e_last_name = $edit_row["last_name"];
        $e_role = $edit_row["role"];
        $e_image = $edit_row["image"];
        $e_details = $edit_row["details"];


    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>

<style>
    .fieldInfo {
        color: rgb(251, 174, 44);
        font-family: Bitter, Georgia, "Times New Roman", Times, serif;
        */ font-size: 1.2em;
    }
</style>
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
                    <i class="fas fa-user-edit"></i> Edit User
                    <small class="text-black-50">Edit User Details</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i>Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-user-edit"></i>Edit User</li>
                </ol>

                <?php
                if (isset($_POST["submit"])) {
                    date_default_timezone_set('Asia/Dhaka');
                    $date = time();
                    $first_name = mysqli_real_escape_string($connectionDB, $_POST["firstName"]);
                    $last_name = mysqli_real_escape_string($connectionDB, $_POST["lastName"]);

                    $password = mysqli_real_escape_string($connectionDB, $_POST["password"]);
                    //salt query for encrypt password
                    $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                    $salt_run = mysqli_query($connectionDB, $salt_query);
                    $salt_row = mysqli_fetch_array($salt_run);
                    $salt = $salt_row["salt"];
                    $insert_password = crypt($password, $salt);

                    $role = $_POST["role"];
                    $image = $_FILES["image"]["name"];

                    if (empty($image)) {
                        $image = $e_image;
                    } else {
                        //image upload start
                        $imageArr = explode('.', $image);
                        $rand = rand(10000, 99999);
                        //image name replace with new name
                        $newImageName = $imageArr[0] . '_' . $rand . '_' . $date . '.' . $imageArr[1];
                        //var_dump($image);
                        $uploadPath = "uploads/authoradmin/" . $newImageName;
                    }

                    $details = mysqli_real_escape_string($connectionDB, $_POST["details"]);


                    if (empty($first_name) || empty($last_name) || empty($image) || empty($details)) {
                        $error_message = "All (*) fields are required!!!";
                    } else {
                        $update_query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', role = '$role', details = '$details'";
                        if (isset($password)) {
                            $update_query .= ", password = '$insert_password'";
                        }
                        if (!empty($newImageName)) {
                            $update_query .= ", image = '$newImageName'";
                        }
                        $update_query .= " WHERE id = '$edit_id'";
                        //var_dump($update_query);
                        if (mysqli_query($connectionDB, $update_query)) {
                            $success_message = "User has been updated!!!";
                            header("refresh:1 url=editUser.php?edit=$edit_id");

                            if (!empty($newImageName)) {
                                $target_pate_to_delete_image = "uploads/authoradmin/$e_image";
                                unlink($target_pate_to_delete_image);
                                unlink("../$target_pate_to_delete_image");
                                move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
                                copy($uploadPath,"../$uploadPath");
                            }
                        } else {
                            $error_message = "Something wrong. User has not bean updated!!!";
                        }
                    }
                }
                ?>

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
                <div class="row">
                    <div class="col-md-8">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="firstName"><span class="fieldInfo">First Name (*):</span></label>
                                <input type="text" name="firstName" id="firstName" class="form-control"
                                       value="<?php echo $e_first_name; ?>" placeholder="First Name">
                            </div>

                            <div class="form-group">
                                <label for="lastName"><span class="fieldInfo">Last Name (*):</span></label>
                                <input type="text" name="lastName" id="lastName" class="form-control"
                                       value="<?php echo $e_last_name; ?>" placeholder="Last Name">
                            </div>

                            <div class="form-group">
                                <label for="password"><span class="fieldInfo">Password (*):</span></label>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Password">
                            </div>

                            <div class="form-group">
                                <label for="role"><span class="fieldInfo">Role (*):</span></label>
                                <select id="role" name="role" class="form-control">
                                    <option value="author" <?php if ($e_role == "author") {
                                        echo "selected";
                                    } ?>>Author
                                    </option>
                                    <option value="admin" <?php if ($e_role == "admin") {
                                        echo "selected";
                                    } ?>>Admin
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image"><span class="fieldInfo">Profile Picture (*):</span></label>
                                <input type="file" id="image" name="image" class="form-control-file card">
                            </div>

                            <div class="form-group">
                                <label for="details"><span class="fieldInfo">Details (*):</span></label>
                                <textarea name="details" class="form-control" id="details" cols="30"
                                          rows="8"><?php echo $e_details; ?></textarea>
                            </div>

                            <input type="submit" value="Update User" name="submit" class="btn btn-primary">
                        </form>
                    </div>

                    <!-- Check user Image from database -->
                    <div class="col-md-4">
                        <?php
                        echo "<img src='uploads/authoradmin/$e_image' class='img-fluid img-thumbnail rounded-circle' 
                            width='100%' alt='user_image'/>";
                        ?>
                    </div>
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
</script>
<!-- Prevent form resubmission when page is refreshed -->
</body>

</html>