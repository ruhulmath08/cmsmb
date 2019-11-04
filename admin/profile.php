<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

$session_username = $_SESSION["username"];
$query = "SELECT * FROM users WHERE username = '$session_username'";
$run = mysqli_query($connectionDB, $query);
$row = mysqli_fetch_array(@$run);

$profile_id = $row["id"];
$profile_image = $row["image"];
$profile_date = getdate($row["date"]);
$day = $profile_date["mday"];
$month = $profile_date["month"];
$year = $profile_date["year"];
$profile_first_name = $row["first_name"];
$profile_last_name = $row["last_name"];
$profile_user_name = $row["username"];
$profile_email = $row["email"];
$profile_role = $row["role"];
$profile_details = $row["details"];

?>
</head>

<body id="profile">
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
                    <i class="fas fa-user"></i> Profile
                    <small class="text-black-50">Personal Details</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i> Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-user"></i> Profile</li>
                </ol>

                <div class="text-center">
                    <img src="uploads/authoradmin/<?php echo $profile_image; ?>" width="200px"
                         class="img-fluid img-thumbnail rounded-circle" alt="profile image">
                </div>
                <a href="editProfile.php?edit=<?php echo $profile_id ?>" class="btn btn-primary fa-pull-right">Edit
                    Profile</a>
                <h3 class="text-center">Profile Details</h3>
                <hr/>

                <table class="table table-bordered table-hover" title="Profile Details">
                    <tr>
                        <td width="20%"><b>User Id:</b></td>
                        <td width="30%"><?php echo $profile_id; ?></td>
                        <td width="20%"><b>SignUp Date</b></td>
                        <td width="30%"><?php echo "$day $month $year"; ?></td>
                    </tr>
                    <tr>
                        <td width="20%"><b>First Name:</b></td>
                        <td width="30%"><?php echo $profile_first_name; ?></td>
                        <td width="20%"><b>Last Name:</b></td>
                        <td width="30%"><?php echo $profile_last_name; ?></td>
                    </tr>
                    <tr>
                        <td width="20%"><b>User Name:</b></td>
                        <td width="30%"><?php echo $profile_user_name; ?></td>
                        <td width="20%"><b>Email:</b></td>
                        <td width="30%"><?php echo $profile_email; ?></td>
                    </tr>
                    <tr>
                        <td width="20%"><b>Role</b></td>
                        <td width="30%"><?php echo $profile_role; ?></td>
                        <td width="20%"><b></b></td>
                        <td width="30%"></td>
                    </tr>
                </table>

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="mb-2">Details</h3>
                        <p class="text-justify card p-2">
                            <?php echo $profile_details; ?>
                        </p>
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
</body>

</html>