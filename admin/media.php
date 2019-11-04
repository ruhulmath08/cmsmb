<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");
//$_SESSION["username"] comes from logging page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

$session_username = $_SESSION["username"];
//var_dump($session_username);
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
                    <i class="fas fa-database"></i> Media
                    <small class="text-black-50">Add or View Media Files</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i> Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-database"></i> Media</li>
                </ol>

                <?php
                if (isset($_POST["submit"])) {
                    $date = time();
                    if (count($_FILES["media"]["name"]) > 0) {
                        for ($i = 0; $i < count($_FILES["media"]["name"]); $i++) {
                            $image = $_FILES["media"]["name"][$i];
                            $imageArr = explode('.', $image);
                            $rand = rand(10000, 99999);
                            if ($image) {
                                $newImageName = $imageArr[0] . '_' . $rand . '_' . $date . '.' . $imageArr[1];
                                $uploadPath = "uploads/media/" . $newImageName;
                            }
                            $tmp_name = $_FILES["media"]["tmp_name"][$i];

                            $query = "INSERT INTO media (image, author, datetime) VALUES ('$newImageName', '$session_username', '$date')";
                            //var_dump($query);
                            if (mysqli_query($connectionDB, $query)) {
                                //for upload image for admin and if success also save in frontend
                                if (move_uploaded_file($tmp_name, $uploadPath)) {
                                    copy($uploadPath, "../$uploadPath");
                                }
                                $success_message = "File uploaded successfully!!!";
                            } else {
                                $error_message = "Something wrong, File not upload!!!";
                            }
                        }
                    }
                }
                ?>

                <!-- Display message -->
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
                <!-- Display message -->

                <hr>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-4">
                            <input type="file" name="media[]" required multiple>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-4">
                            <input type="submit" name="submit" class="btn btn-primary" value="Add Media">
                        </div>
                    </div>
                </form>

                <hr/>
                <!--Display media images-->
                <div class="row">
                    <?php
                    $get_query = "SELECT * FROM media ORDER BY id DESC";
                    $get_run = mysqli_query($connectionDB, $get_query);
                    if (mysqli_num_rows($get_run) > 0) {
                        while ($dataRow = mysqli_fetch_array($get_run)) {
                            $get_image = $dataRow["image"];

                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                <a href="images/media/<?php echo $get_image; ?>">
                                    <img src="uploads/media/<?php echo $get_image; ?>" width="100%" class="img-thumbnail"
                                         alt="image">
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<h3>No media available!!!</h3>";
                    }
                    ?>
                </div>
                <!--Display media images-->
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