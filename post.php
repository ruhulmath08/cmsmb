<?php require_once("inc/function.php"); ?>
<?php require_once("inc/top.php"); ?>
<body>
<?php require_once("inc/header.php"); ?>
<!-- NavBar End -->

<?php
if (isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];
    //Views Count Query
    $views_query = "UPDATE posts SET views = views+1 WHERE id = '$post_id'";
    mysqli_query($connectionDB, $views_query);
    //Views Count Query
    $query = "SELECT * FROM posts WHERE status = 'publish' AND id = '$post_id'";
    $run = mysqli_query($connectionDB, $query);
    if (mysqli_num_rows($run) > 0) {
        $row = mysqli_fetch_array($run);
        $postId = $row["id"];
        $postDate = getdate($row["date"]);
        $postTitle = $row["title"];
        $postAuthor = $row["author"];
        $postAuthorImage = $row["author_image"];
        $postImage = $row["image"];
        $postCategory = $row["categories"];
        $postData = $row["post_data"];
        $day = $postDate["mday"];
        $month = $postDate["month"];
        $year = $postDate["year"];
    } else {
        //if bad data comes throw URL, go index page
        header("Location: index.php");
    }
} else {
    //if bad data comes throw URL, go index page
    header("Location: index.php");
}
?>

<!-- Jumbotron Start -->
<div class="jumbotron">
    <div class="container">
        <div id="details" class="d-flex justify-content-center flex-column animated fadeInLeft">
            <h1>Custom <span>Post</span></h1>
            <p>Here we can put your own tag line to make it more attractive</p>
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

                <!-- FullPost Start-->
                <div class="post">
                    <div class="row mb-1">
                        <div class="col-md-2 post-date">
                            <div class="day"><?php echo $day; ?></div>
                            <div class="month"><?php echo $month; ?></div>
                            <div class="year"><?php echo $year; ?></div>
                        </div>
                        <div class="row col-md-8 post-title">
                            <a href="post.php?post_id=<?php echo $postId; ?>">
                                <h2><?php echo stripcslashes($postTitle); ?></h2>
                            </a>
                            <p>Written By: <span><?php echo $postAuthor; ?></span></p>
                        </div>
                        <div class="row col-md-2 profile-picture">
                            <a href="#" class="mx-auto my-auto d-block">
                                <img src="uploads/authoradmin/<?php echo $postAuthorImage; ?>"
                                     class="rounded-circle img-fluid "
                                     alt="Profile Picture">
                            </a>
                        </div>
                    </div>
                    <a href="uploads/blog/<?php echo $postImage; ?>">
                        <img src="uploads/blog/<?php echo $postImage; ?>" alt="post image"
                             class="img-thumbnail img-fluid mx-auto my-auto d-block">
                    </a>
                    </a>
                    <div class="desc"><?php echo $postData; ?></div>
                    <div class="bottom">
                        <span class="first">
                            <i class="fa fa-folder"></i><a href="#"><?php echo ucwords(" " . $postCategory); ?></a>
                        </span> |
                        <span class="second pl-4">
                            <i class="fa fa-comment"></i><a href="#"> Comments</a>
                        </span>
                    </div>
                </div>
                <!-- FullPost End-->

                <!-- Related Post Start-->
                <div class="container testimonial-group mt-3 pl-2 pt-2 bg-white">
                    <div class="row text-center flex-nowrap pb-2">
                        <?php
                        //test title
                        $confPostTitle = mysqli_real_escape_string($connectionDB, $postTitle);
                        //var_dump($confPostTitle);
                        $r_query = "SELECT * FROM posts WHERE status = 'publish' AND title LIKE '%$confPostTitle%' AND id != '$post_id' LIMIT 5";
                        //var_dump($r_query);
                        $r_run = mysqli_query($connectionDB, $r_query);
                        if (mysqli_num_rows($r_run) > 0) {
                            while ($rRow = mysqli_fetch_array($r_run)) {
                                $rId = $rRow['id'];
                                $rTitle = $rRow['title'];
                                $rImage = $rRow['image'];

                                ?>
                                <div class="col-sm-4 myContent">
                                    <div class="card vScrollImg">
                                        <img src="uploads/blog/<?php echo $rImage; ?>" alt="post_image"
                                             class="img-fluid card-img-top align-self-center">
                                        <div class="card-body text-wrap text-left text-justify">
                                            <h5 class="card-title overflow-hidden">
                                                <a href="#">
                                                    <?php echo $rTitle; ?>
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            echo "<h3 class='pl-4'>No related post available...</h3>";
                        } ?>
                    </div>
                </div>
                <!-- Related Post End-->

                <!-- About author start-->
                <div class="author mt-3">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="uploads/authoradmin/<?php echo $postAuthorImage; ?>"
                                 class="rounded-circle img-fluid"
                                 alt="author image">
                        </div>
                        <div class="col-sm-9">
                            <h4 class="text-primary"><?php echo $postAuthor; ?></h4>
                            <!--Author details from author table-->
                            <?php
                            $author_query = "SELECT details from users WHERE username = '$postAuthor'";
                            $author_run = mysqli_query($connectionDB, $author_query);
                            if (mysqli_num_rows($author_run) > 0) {
                                $dataRaw = mysqli_fetch_array($author_run);
                                $author_details = $dataRaw["details"];
                                //var_dump($author_details);
                                ?>
                                <p><?php echo $author_details; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- About author end-->

                <!-- Comment Section Start-->
                <div class="comment mt-3">
                    <h3>Comments (<?php echo numberOfTotalComment($post_id); ?>)</h3>
                    <hr/>
                    <?php
                    $c_query = "SELECT * FROM comments WHERE status = 'approve' AND post_id = '$post_id' ORDER BY id DESC";
                    $c_run = mysqli_query($connectionDB, $c_query);
                    if (mysqli_num_rows($c_run) > 0) {
                        while ($cRow = mysqli_fetch_array($c_run)) {
                            $commenterId = $cRow["id"];
                            $commenterName = $cRow["name"];
                            $commenterUserName = $cRow["username"];
                            $commenterImage = $cRow["image"];
                            $commenterComment = $cRow["comment"];
                            ?>
                            <div class="row singleComment">
                                <div class="col-sm-2">
                                    <img src="images/<?php echo $commenterImage ?>" class="rounded-circle img-fluid"
                                         alt="Commenter-picture">
                                </div>
                                <div class="col-sm-10">
                                    <h5><?php echo ucwords($commenterName); ?></h5>
                                    <p class="text-justify pb-1"><?php echo $commenterComment ?></p>
                                </div>
                            </div>
                            <hr class="mt-0 pt-0"/>
                            <?php
                        }
                    } else {
                        echo "<h1>No Comment Yet!!!</h1>";
                    }
                    ?>
                </div>
                <!-- Comment Section End-->

                <!--For insert form value start-->
                <?php
                if (isset($_POST["submit"])) {
                    $csName = mysqli_real_escape_string($connectionDB, $_POST["commenterName"]);
                    $csEmail = mysqli_real_escape_string($connectionDB, $_POST["commenterEmail"]);
                    $csWebSite = mysqli_real_escape_string($connectionDB, $_POST["commenterWebsite"]);
                    $csComment = mysqli_real_escape_string($connectionDB, $_POST["commenterComment"]);
                    $csDate = time();
                    if (empty($csName) || empty($csEmail) || empty($csComment)) {
                        $error_msg = "All fields are required...";
                    } else {
                        $cs_query = "INSERT INTO comments (date, name, username, post_id, email, website,
                        image, comment, status) VALUES ('$csDate', '$csName', 'user', '$post_id', '$csEmail',
                        '$csWebSite', 'jannat.jpg', '$csComment', 'pending')";
                        //var_dump($cs_query);
                        if (mysqli_query($connectionDB, $cs_query)) {
                            $success_message = "Comment submitted and waiting for approval...";
                            $csName = "";
                            $csEmail = "";
                            $csWebSite = "";
                            $csComment = "";
                        } else {
                            $error_message = "Something wrong Comment not submitted...";
                        }
                    }
                }
                ?>
                <!--For insert form value end-->

                <!-- Comment Box Start-->
                <form action="" method="post">
                    <!--prevent redirection error-->
                    <?php
                    //                    $rand = rand();
                    //                    $_SESSION['rand'] = $rand;
                    ?>
                    <!--prevent redirection error-->
                    <div class="card mt-3">
                        <div class="card-header commentBoxCart">
                            <h5 class="fieldInfo">Share your thoughts about this post</h5>
                        </div>
                        <div class="card-body commentBoxCartBody">
                            <!--Username-->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input class="form-control" type="text" name="commenterName" placeholder="Name"
                                           value="<?php if (isset($csName)) {
                                               echo $csName;
                                           } ?>">
                                </div>
                            </div>
                            <!--Email-->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control" type="email" name="commenterEmail" placeholder="Email"
                                           value="<?php if (isset($csEmail)) {
                                               echo $csEmail;
                                           } ?>">
                                </div>
                            </div>
                            <!--Website-->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    </div>
                                    <input class="form-control" type="url" name="commenterWebsite"
                                           placeholder="Website URL (Optional)"
                                           value="<?php if (isset($csWebSite)) {
                                               echo $csWebSite;
                                           } ?>">
                                </div>
                            </div>
                            <!--TextArea-->
                            <div class="form-group">
                                <!--Open (and close!) your PHP tags right after, and before, your textarea tags otherwise textarea takes whitespace after refresh-->
                                <textarea class="form-control" name="commenterComment" cols="30" rows="6"
                                          placeholder="Write your comment here"><?php if (isset($csComment)) {
                                        echo $csComment;
                                    } ?></textarea>
                            </div>
                            <!--Submit Button-->
                            <div>
                                <button class="btn btn-primary float-right mb-1" name="submit">Submit</button>
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
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Comment Box End-->
            </div>

            <!--Sidebar start -->
            <div class="col-md-4 mt-3">
                <?php require_once("inc/sidebar.php"); ?>
            </div>
            <!-- Sidebar End-->
        </div>
    </div><!-- Row end -->
    </div><!-- container End-->
</section>
<!-- Main Section End-->

<!-- Footer Start-->
<?php require_once("inc/footer.php"); ?>
<!-- Footer End-->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/prism.js"></script>
<script src="js/clipboard.min.js"></script>
<script>
    $("pre").addClass("line-numbers");
</script>
<!-- Prevent form resubmission when page is refreshed -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<!-- Prevent form resubmission when page is refreshed -->
</body>

</html>