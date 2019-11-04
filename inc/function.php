<?php include_once "DB.php" ?>

<?php
//function for count post based on category
function totalPostBasedOnCategory($categoryName)
{
    global $connectionDB;
    $category_query = "SELECT COUNT(*) FROM posts WHERE categories = '$categoryName'";
    $category_result = mysqli_query($connectionDB, $category_query);
    $category_rows = mysqli_fetch_row($category_result);
    $category_total = $category_rows[0];
    return $category_total;
}

// function for display number of total comment
function numberOfTotalComment($postID)
{
    global $connectionDB;
    $comment_query = "SELECT COUNT(*) FROM comments WHERE post_id = '$postID' && status = 'approve'";
    $comment_result = mysqli_query($connectionDB, $comment_query);
    $comment_rows = mysqli_fetch_row($comment_result);
    $comment_total = $comment_rows[0];
    return $comment_total;
}

?>


