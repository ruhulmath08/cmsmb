<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" width="30px" alt="logo"> Code Step by Step
        </a>
        <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto float-lg-right">
                <li class="nav-item" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" hrDef="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-list-alt"></i> Categories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $query = "SELECT * FROM categories ORDER BY id DESC";
                        $run = mysqli_query($connectionDB, $query);
                        if (mysqli_num_rows($run) > 0) {
                            while ($row = mysqli_fetch_array($run)) {
                                $categoryId = $row["id"];
                                $categoryName = $row["category"];
                                ?>
                                <a class="dropdown-item"
                                   href="index.php?cat=<?php echo $categoryId; ?>"><?php echo ucfirst($categoryName); ?></a>
                                <?php
                            }
                        } else {
                            echo '<a class="dropdown-item"
                               href="#">No Category Yet</a>';
                        }
                        ?>
                    </div>
                </li>

                <li class="nav-item" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <a class="nav-link" href="contactus.php">
                        <i class="fa fa-phone-square-alt"></i> Contact Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>