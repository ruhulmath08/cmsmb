<?php
$session_role2 = $_SESSION["role"];
$session_username2 = $_SESSION["username"];
?>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <a class="navbar-brand" href="./index.php">RUHUL'S BLOG</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href=""><b>Welcome: </b>
                    <i class="fa fa-user">
                        <?php echo $session_username2; ?> |
                    </i>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="addPost.php"><i class="fa fa-plus-square"></i> Add Post</a>
            </li>

            <?php if ($session_role2 == "admin") {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="addUser.php"><i class="fa fa-user-plus"></i> Add User</a>
                </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link" href="profile.php"><i class="fa fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
            </li>
        </ul>
    </div>
</nav>
