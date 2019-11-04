<?php
$session_role = $_SESSION["role"];
//count pending comment from comments table
$comment_query = "SELECT COUNT(*) FROM comments WHERE status = 'pending'";
$comment_result = mysqli_query($connectionDB, $comment_query);
$comment_rows = mysqli_fetch_row($comment_result);
$comment_total = $comment_rows[0];

//count post from posts table
$post_query = "SELECT COUNT(*) FROM posts";
$post_result = mysqli_query($connectionDB, $post_query);
$post_rows = mysqli_fetch_row($post_result);
$post_total = $post_rows[0];

//count category from categories table
$category_query = "SELECT COUNT(*) FROM categories";
$category_result = mysqli_query($connectionDB, $category_query);
$category_rows = mysqli_fetch_row($category_result);
$category_total = $category_rows[0];

//count user from users table
$user_query = "SELECT COUNT(*) FROM users";
$user_result = mysqli_query($connectionDB, $user_query);
$user_rows = mysqli_fetch_row($user_result);
$user_total = $user_rows[0];
?>
<div class="list-group">
    <a href="index.php" class="list-group-item list-group-item-action active">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="post.php" class="list-group-item  list-group-item-action">
        <i class="fas fa-file-alt"></i> All Posts
        <span class="badge badge-primary badge-pill float-right">
            <?php if ($post_total > 0) {
                echo $post_total;
            } else {
                echo 0;
            } ?>
        </span>
    </a>
    <a href="media.php" class="list-group-item  list-group-item-action">
        <i class="fas fa-database"></i> Media
        <!--        <span class="badge badge-primary badge-pill float-right">15</span>-->
    </a>

    <?php
    if ($session_role == "admin") {
        ?>

        <a href="comments.php" class="list-group-item list-group-item-action">
            <i class="fas fa-comment"></i> Comments
            <span class="badge badge-primary badge-pill float-right">
                <?php if ($comment_total > 0) {
                    echo $comment_total;
                } else {
                    echo 0;
                } ?>
            </span>
        </a>
        <a href="categories.php" class="list-group-item list-group-item-action">
            <i class="fas fa-folder-open"></i> Categories
            <span class="badge badge-primary badge-pill float-right">
                <?php if ($category_total > 0) {
                    echo $category_total;
                } else {
                    echo 0;
                } ?>
            </span>
        </a>
        <a href="users.php" class="list-group-item list-group-item-action">
            <i class="fas fa-users"></i> Users
            <span class="badge badge-primary badge-pill float-right">
                <?php if ($user_total > 0) {
                    echo $user_total;
                } else {
                    echo 0;
                } ?>
            </span>
        </a>
    <?php } ?>
</div>