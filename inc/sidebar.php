<?php require_once("inc/function.php"); ?>
<div class="widgets">
    <form action="index.php" method="post">
        <div class="input-group">
            <input type="text" class="form-control" name="search-title" placeholder="Search for...">
            <div class="input-group-append">
                <input type="submit" value="Go!" class="btn btn-success" name="search">
            </div>
        </div>
    </form>
</div>

<!-- Categories Start-->
<div class="card">
    <div class="card-header bg-info text-white">
        <h4>Categories</h4>
    </div>
    <div class="card border-0 shadow scroll">
        <div class="card-body pb-0" style="overflow-y: scroll; height:250px;">
            <!--PHP code for display all categories-->
            <?php
            $c_query = "SELECT * FROM categories";
            $c_run = mysqli_query($connectionDB, $c_query);
            if (mysqli_num_rows($c_run) > 0) {
                while ($cRow = mysqli_fetch_array($c_run)) {
                    $cId = $cRow["id"];
                    $cCategory = $cRow["category"];
                    ?>
                    <div class="d-flex justify-content-between small">
                        <h6>
                            <span>
                                <a href="index.php?cat=<?php echo $cId; ?>">
                                    <?php echo ucwords($cCategory); ?>
                                </a>
                            </span>
                        </h6>
                        <h6>
                            <span class="text-danger">(<?php echo totalPostBasedOnCategory($cCategory) ?>)</span>
                        </h6>
                    </div>
                    <hr class="my-2">
                    <?php
                }
            } else {
                echo "<h3>No Category Available</h3>";
            }
            ?>
        </div>
    </div>
</div>
<!-- Categories End-->

<!-- Recent Post Start-->
<div class="card mt-3">
    <div class="card-header bg-info text-white">
        <div class="lead">Recent Post</div>
    </div>
    <div class="card">
        <?php
        $r_query = "SELECT id, title, image,date FROM posts WHERE status = 'publish' ORDER BY id DESC LIMIT 5";
        $r_run = mysqli_query($connectionDB, $r_query);
        if (mysqli_num_rows($r_run) > 0) {
            while ($rRow = mysqli_fetch_array($r_run)) {
                $rId = $rRow["id"];
                $rTitle = $rRow["title"];
                $rImage = $rRow["image"];
                $rDate = getdate($rRow["date"]);
                $rDay = $rDate["mday"];
                $rMonth = $rDate["month"];
                $rYear = $rDate["year"];
                ?>
                <a href="post.php?post_id=<?php echo $rId; ?>" target="_blank">
                    <img src="uploads/blog/<?php echo $rImage; ?>" class="card-img-top img-fluid" alt="post image">
                </a>
                <div class="card-body">
                    <a href="post.php?post_id=<?php echo $rId; ?>" target="_blank">
                        <h5 class="card-title"><?php echo stripcslashes($rTitle); ?></h5>
                    </a>
                    <p class="card-text border-bottom float-right">
                        <small class="text-muted "><i class="fa fa-clock"></i>
                            <?php echo "$rDay $rMonth $rYear"; ?>
                        </small>
                    </p>
                </div>
                <?php
            }
        } else {
            echo "<h3>No Post Available</h3>";
        }
        ?>

    </div>
</div>
<!-- Recent Post End-->

<!-- Popular Post Start -->
<div class="card mt-3 mb-3">
    <div class="card-header bg-info text-white">
        <div class="lead">Popular Post</div>
    </div>
    <div class="card-body card pb-2">

        <?php
        $p_query = "SELECT id, title, image,date, views FROM posts WHERE status = 'publish' ORDER BY views DESC LIMIT 5";
        $p_run = mysqli_query($connectionDB, $p_query);
        if (mysqli_num_rows($p_run) > 0) {
            while ($pRow = mysqli_fetch_array($p_run)) {
                $pId = $pRow["id"];
                $pTitle = $pRow["title"];
                $pImage = $pRow["image"];
                $pDate = getdate($pRow["date"]);
                $pViews = $pRow["views"];
                $pDay = $pDate["mday"];
                $pMonth = $pDate["month"];
                $pYear = $pDate["year"];

                ?>
                <div class="media">
                    <a href="post.php?post_id=<?php echo $pId; ?>" target="_blank">
                        <img src="uploads/blog/<?php echo $pImage; ?>"
                             class="d-block img-fluid align-self-start card img-thumbnail"
                             width="140" height="80" alt="post_image">
                    </a>
                    <div class="media-body ml-2" height="80">
                        <a href="post.php?post_id=<?php echo $pId; ?>" target="_blank">
                            <h6 class="lead"><?php echo stripcslashes($pTitle); ?></h6>
                        </a>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fa fa-clock"></i><?php echo " $pDay $pMonth $pYear"; ?>
                            </small>
                        </p>
                        <span class="float-right badge badge-dark text-light p-2 float-right" title="Number of views">
                            <i class="fas fa-eye pr-2"></i><?php echo $pViews; ?>
                        </span>
                    </div>
                </div>
                <hr>
                <?php
            }
        } else {
            echo "<h3>No Post Available</h3>";
        }
        ?>

    </div>
</div>
</div>
<!-- Popular Post End -->