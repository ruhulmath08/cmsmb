<?php require_once("inc/top.php"); ?>
</head>

<body>
<?php require_once("inc/header.php");
//Pagination start
$number_of_posts = 3;

//for page_id => index.php?page=1
if (isset($_GET["page"])) {
    $page_id = $_GET["page"];
    //check value is negative or non-numeric value
    if ($page_id <= 0 || !is_numeric($page_id)) {
        $page_id = 1;
    }
} else { //if page_id not set in URL
    $page_id = 1;
}

//for cat_id => index.php?cat=14
if (isset($_GET["cat"])) {
    $cat_id = $_GET["cat"];
    $cat_query = "SELECT * FROM categories where id = '$cat_id'";
    $cat_run = mysqli_query($connectionDB, $cat_query);
    $cat_row = mysqli_fetch_array($cat_run);
    $cat_name = $cat_row["category"];
}

if (isset($_POST["search"])) {
    $search = $_POST["search-title"];
    $all_posts_query = "SELECT * FROM posts WHERE status = 'publish'";
    $all_posts_query .= " AND tags LIKE '%$search%'";
    $all_posts_run = mysqli_query($connectionDB, $all_posts_query);
    $all_posts = mysqli_num_rows($all_posts_run);
    $total_pages = ceil($all_posts / $number_of_posts);
    $posts_start_from = ($page_id - 1) * $number_of_posts;
    //Search pagination end
} else {
    $all_posts_query = "SELECT * FROM posts WHERE status = 'publish'";
    if (isset($cat_name)) {
        $all_posts_query .= " AND categories = '$cat_name'";
    }
    $all_posts_run = mysqli_query($connectionDB, $all_posts_query);
    $all_posts = mysqli_num_rows($all_posts_run);
    $total_pages = ceil($all_posts / $number_of_posts);
    $posts_start_from = ($page_id - 1) * $number_of_posts;
    //Pagination end
}

?>
<!-- NavBar End -->

<!-- Jumbotron Start -->
<div class="jumbotron">
    <div class="container">
        <div id="details" class="d-flex justify-content-center flex-column animated fadeInLeft">
            <h1>RUHUL'S <span>Blog</span></h1>
            <p>Learn the best from the best</p>
        </div>
    </div>
    <img src="images/top-image.jpg" alt="Top Image">
</div>
<!-- Jumbotron End -->

<!-- Main Section Start-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-3">
                <!-- Slider Start-->
                <?php
                $slider_query = "SELECT * FROM posts WHERE status = 'publish' ORDER BY id DESC LIMIT 5";
                $slider_run = mysqli_query($connectionDB, $slider_query);
                if (mysqli_num_rows(($slider_run))) {
                $count = mysqli_num_rows($slider_run);
                ?>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                        for ($i = 0; $i < $count; $i++) {
                            if ($i == 0) {
                                echo "<li data-target='#carouselExampleIndicators' data-slide-to='" . $i . "' class='active'></li>";
                            } else {
                                echo "<li data-target='#carouselExampleIndicators' data-slide-to='" . $i . "'></li>";
                            }
                        }
                        ?>
                    </ol>
                    <!-- Wrapper for slides-->
                    <div class="carousel-inner">
                        <?php
                        $check = 0;
                        while ($sliderRow = mysqli_fetch_array($slider_run)) {
                        $sliderId = $sliderRow["id"];
                        $sliderImage = $sliderRow["image"];
                        $sliderTitle = $sliderRow["title"];
                        $check = $check + 1;
                        if ($check == 1) {
                            echo "<div class='carousel-item active'>";
                        } else {
                            echo "<div class='carousel-item'>";
                        }
                        ?>
                        <a href="post.php?post_id=<?php echo $sliderId; ?>">
                            <img src="uploads/blog/<?php echo $sliderImage; ?>" height="422px" class="d-block w-100"
                                 alt="slide 1">
                        </a>
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $sliderTitle; ?></h5>
                            <!-- We can display some description here -->
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!-- Wrapper for slides-->
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                   data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                   data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <?php
            }
            ?><!-- Slider End-->

            <!-- PHP post data -->
            <?php
            if (isset($_POST["search"])) {
                $search = $_POST["search-title"];
                $query = "SELECT * FROM posts WHERE status = 'publish'";
                $query .= " and tags LIKE '%$search%'";
                $query .= " ORDER BY id DESC LIMIT $posts_start_from, $number_of_posts";
            } else {
                $query = "SELECT * FROM posts WHERE status = 'publish'";
                if (isset($cat_name)) {
                    $query .= " and categories = '$cat_name'";
                }
                $query .= " ORDER BY id DESC LIMIT $posts_start_from, $number_of_posts";
            }
            $run = mysqli_query($connectionDB, $query);
            if (mysqli_num_rows($run) > 0) {
                while ($row = mysqli_fetch_array($run)) {
                    $postId = $row["id"];
                    $postDate = getdate($row["date"]);
                    $postTitle = $row["title"];
                    $postAuthor = $row["author"];
                    $postAuthorImage = $row["author_image"];
                    $postImage = $row["image"];
                    $postCategories = $row["categories"];
                    $postTags = $row["tags"];
                    $postPostData = $row["post_data"];
                    $postViews = $row["views"];
                    $postStatus = $row["status"];
                    ?>
                    <!-- Post Start-->
                    <div class="post mt-3">
                        <div class="row">
                            <div class="col-md-2 post-date">
                                <div class="day"><?php echo $postDate["mday"]; ?></div>
                                <div class="month"><?php echo $postDate["month"]; ?></div>
                                <div class="year"><?php echo $postDate["year"]; ?></div>
                            </div>
                            <div class="row col-md-8 post-title">
                                <a href="post.php?post_id=<?php echo $postId; ?>">
                                    <h2><?php echo stripslashes($postTitle); ?></h2>
                                </a>
                                <p>Written By: <span><?php echo $postAuthor; ?></span></p>
                            </div>
                            <div class="row col-md-2 profile-picture">
                                <img src="uploads/authoradmin/<?php echo $postAuthorImage; ?>"
                                     class="rounded-circle img-fluid mx-auto my-auto d-block"
                                     alt="Profile Picture">
                            </div>
                        </div>
                        <a href="post.php?post_id=<?php echo $postId; ?>"><img
                                    src="uploads/blog/<?php echo $postImage; ?>" alt="post image"
                                    class="img-thumbnail img-fluid mx-auto my-auto d-block"></a>
                        <div class="desc"><?php echo substr($postPostData, 0, 500) . "..."; ?></div>
                        <div class="overflow-hidden m-1">
                            <a href="post.php?post_id=<?php echo $postId; ?>" class="btn btn-info float-right">Read
                                More
                                ...</a>
                        </div>
                        <div class="bottom">
                                <span class="first">
                                    <i class="fa fa-folder"></i><a
                                            href="index.php?cat=<?php echo $postCategories; ?>"> <?php echo $postCategories; ?></a>
                                </span>|
                            <span class="second pl-4"><i class="fa fa-comment"></i><a href="#"> Comments</a></span>
                        </div>
                    </div><!-- Post End-->
                    <?php
                }
            } else {
                echo "<h2 class='text-center'>No Post Available</h2>";
            }
            ?>
            <!-- PHP post data -->


            <!-- Pagination Start-->
            <nav id="pagination" class="mt-3">
                <ul class="pagination justify-content-center">
                    <!-- Backward Button Start-->
                    <?php
                    if ($page_id > 1) {
                        ?>
                        <li class="page-item">
                            <a href="index.php?page=<?php echo $page_id - 1 ?>" class="page-link">&laquo;</a>
                        </li>
                        <?php
                    }
                    ?>
                    <!-- Backward Button End-->

                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item " . ($page_id == $i ? "active" : "") . "'>
                        <a class='page-link' href='index.php?page=" . $i . "&" . (isset($cat_name) ? "cat=$cat_id" : "") . "'>$i</a>
                        </li>";
                    }
                    ?>

                    <!-- Forward Button Start-->
                    <?php
                    if ($page_id + 1 <= $total_pages) {
                        ?>
                        <li class="page-item">
                            <a href="index.php?page=<?php echo $page_id + 1; ?>" class="page-link">&raquo;</a>
                        </li>

                    <?php }
                    ?>
                    <!-- Forward Button End-->
                </ul>
            </nav>
            <!-- Pagination End-->
        </div>
        <!--Sidebar start -->
        <div class="col-md-4 mt-3">
            <?php require_once("inc/sidebar.php"); ?>
        </div><!-- Sidebar End-->
    </div>
    </div><!-- Row end -->
    </div><!-- container End-->
</section>
<!-- Main Section End-->

<!-- Footer Start-->
<?php include_once("inc/footer.php"); ?>
<!-- Footer End-->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>