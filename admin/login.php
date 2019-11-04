<?php
ob_start();
session_start();
require_once("../inc/DB.php");

if (isset($_POST["submit"])) {
    $userName = mysqli_real_escape_string($connectionDB, strtolower($_POST["username"]));
    $userPassword = mysqli_real_escape_string($connectionDB, $_POST["password"]);

    $check_username_query = "SELECT * FROM users WHERE username = '$userName'";
    $check_username_run = mysqli_query(@$connectionDB, $check_username_query);
    if (mysqli_num_rows($check_username_run) > 0) {
        $row = mysqli_fetch_array($check_username_run);
        $dbUsername = $row["username"];
        $dbPassword = $row["password"];
        $dbRole = $row["role"];
        $dbAuthorImage = $row["image"];

        $userPassword = crypt($userPassword, $dbPassword);
        if ($userName == $dbUsername && $userPassword == $dbPassword) {
            header("Location: index.php");
            $_SESSION["username"] = $dbUsername;
            $_SESSION["role"] = $dbRole;
            $_SESSION["author_image"] = $dbAuthorImage;
        }
    } else {
        $error_message = "Wrong username or password!!!";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <link rel="shortcut icon" href="images/favicon.png" type="image/png"/>
    <title>Login | RUHUL'S Blog</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS for animation-->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/login.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body class="text-center">
<form class="form-signin animated shake" action="" method="post">
    <img class="mb-4" src="images/favicon.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">RUHUL'S Blog Login</h1>

    <label for="username" class="sr-only">Username</label>
    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>

    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

    <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Sign In">

    <div>
        <label>
            <?php
            if (isset($error_message)) {
                echo "<h3 class='text-danger'>$error_message</h3>";
            }
            ?>
        </label>
    </div>

    <p class="mt-5 mb-3 cText">&copy; 2019-2020</p>
</form>

<!-- Prevent form resubmission when page is refreshed -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<!-- Prevent form resubmission when page is refreshed -->
</body>

</html>