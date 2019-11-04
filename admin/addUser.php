<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}//only Admin can access this page
elseif (isset($_SESSION["username"]) && $_SESSION["role"] == "author") {
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
                    <i class="fas fa-user-plus"></i> Add Users
                    <small class="text-black-50">Add New User</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i> Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-user-plus"></i> Add New Users</li>
                </ol>

                <hr/>

                <?php
                if (isset($_POST["submit"])) {
                    date_default_timezone_set('Asia/Dhaka');
                    $date = time();
                    $first_name = mysqli_real_escape_string($connectionDB, $_POST["firstName"]);
                    $last_name = mysqli_real_escape_string($connectionDB, $_POST["lastName"]);
                    $user_name = mysqli_real_escape_string($connectionDB, strtolower($_POST["userName"]));
                    $user_name_trim = preg_replace("/\s+/", "", $user_name);

                    $email = mysqli_real_escape_string($connectionDB, strtolower($_POST["email"]));
                    //check username or mail exist or not
                    $query_check_mail = "SELECT * FROM users WHERE username = '$user_name' OR email = '$email'";
                    $run_check_mail = mysqli_query($connectionDB, $query_check_mail);
                    $query_check_result = mysqli_num_rows($run_check_mail);

                    $password = mysqli_real_escape_string($connectionDB, $_POST["password"]);
                    //salt query for encrypt password
                    $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                    $salt_run = mysqli_query($connectionDB, $salt_query);
                    $salt_row = mysqli_fetch_array($salt_run);
                    $salt = $salt_row["salt"];
                    $password = crypt($password, $salt);

                    $role = $_POST["role"];
                    //image upload start
                    $image = $_FILES["image"]["name"];
                    $imageArr = explode('.', $image);
                    $rand = rand(10000, 99999);
                    if ($image) {
                        $newImageName = $imageArr[0] . '_' . $rand . '_' . $date . '.' . $imageArr[1];
                        $uploadPath = "uploads/authoradmin/" . $newImageName;
                    }

                    if (empty($first_name) || empty($last_name) || empty($user_name) ||
                        empty($email) || empty($password) || empty($image)) {
                        $error_message = "All (*) fields are required!!!";
                    } else if ($user_name != $user_name_trim) {
                        $error_message = "Don't use space in username";
                    } else if ($query_check_result > 0) {
                        $error_message = "Username or Email Already Exist!!!";
                    } else {
                        $insert_query = "INSERT INTO users(date, first_name, last_name, username, email, image, password, role) 
                            VALUES ('$date', '$first_name', '$last_name', '$user_name', '$email', '$newImageName', '$password', '$role')";
                        if (mysqli_query($connectionDB, $insert_query)) {
                            $success_message = "User Added Successfully...";
                            move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
                            copy($uploadPath, "../$uploadPath");

                            $image_check = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                            $image_run = mysqli_query($connectionDB, $image_check);
                            $image_row = mysqli_fetch_array($image_run);
                            $check_image = $image_row["image"];

                            //clear form value after submit form successfully.
                            $first_name = "";
                            $last_name = "";
                            $user_name = "";
                            $email = "";

                        } else {
                            $error_message = "Something wrong! User not Added!!!";
                        }
                    }
                }
                ?>

                <div class="row">
                    <div class="col-md-8">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="firstName"><span class="fieldInfo">First Name (*):</span></label>
                                <!--Print success or error message start-->
                                <?php
                                if (isset($error_message)) {
                                    echo "<span class='fa-pull-right' style='color: red'>$error_message</span>";
                                } else if (isset($success_message)) {
                                    echo "<span class='fa-pull-right' style='color: green'>$success_message</span>";
                                }
                                ?>
                                <!--Print success or error message end-->
                                <input type="text" name="firstName" id="firstName" class="form-control"
                                       value="<?php if (isset($first_name)) {
                                           echo $first_name;
                                       } ?>"
                                       placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="lastName"><span class="fieldInfo">Last Name (*):</span></label>
                                <input type="text" name="lastName" id="lastName" class="form-control"
                                       value="<?php if (isset($last_name)) {
                                           echo $last_name;
                                       } ?>" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="userName"><span class="fieldInfo">User Name (*):</span></label>
                                <input type="text" name="userName" id="userName" class="form-control"
                                       value="<?php if (isset($user_name)) {
                                           echo $user_name;
                                       } ?>" placeholder="User Name">
                            </div>
                            <div class="form-group">
                                <label for="email"><span class="fieldInfo">Email (*):</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="<?php if (isset($email)) {
                                           echo $email;
                                       } ?>" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="fieldInfo">Password (*):</span></label>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="role"><span class="fieldInfo">Role (*):</span></label>
                                <select id="role" name="role" class="form-control">
                                    <option value="author">Author</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image"><span class="fieldInfo">Profile Picture (*):</span></label>
                                <input type="file" id="image" name="image" class="form-control-file">
                            </div>
                            <input type="submit" value="Add User" name="submit" class="btn btn-primary">
                        </form>
                    </div>

                    <!-- Check user Image from database -->
                    <div class="col-md-4">
                        <?php
                        if (isset($check_image)) {
                            echo "<img src='uploads/authoradmin/$check_image' class='img-fluid img-thumbnail rounded-circle' width='100%' alt='user_image'/>";
                        }
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