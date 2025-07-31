<?php include "config/database.php"?>

<?php

session_start();

if(isset($_POST["delete_submit"])) {
    $post_id = $_POST["delete_submit"];
    $delete_query = "DELETE FROM posts WHERE post_id = ?";
    $statement = mysqli_prepare($connection, $delete_query);
    mysqli_stmt_bind_param($statement, "i", $post_id);
    mysqli_stmt_execute($statement);
    
    header("Location: profile.php");
}

if(isset($_POST["edit_submit"])) {
    
    $post_id = $_POST["edit_submit"];
    header("Location: editpost.php?post_id=$post_id");

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/546f520f0b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/style.css">
    <title>Profile</title>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">BLOGHUB</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" aria-current="page" href="profile.php">MY POSTS</a>
                        <a class="nav-link" href="newpost.php">NEW POST</a>
                        <a class="nav-link active" href="blog.php">BLOG</a>
                        <a class="nav-link" href="logout.php">SIGN OUT</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="profile-main">
            <?php

            $query = "SELECT * FROM posts";
            $result = mysqli_query($connection, $query);
            $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            shuffle($posts);


            foreach ($posts as $post) {

                $postUserId = $post['user_id'];
                $userQuery = "SELECT full_name FROM users WHERE user_id = ?";
                $userStatement = mysqli_prepare($connection, $userQuery);
                mysqli_stmt_bind_param($userStatement, "i", $postUserId);
                mysqli_stmt_execute($userStatement);
                $userResult = mysqli_stmt_get_result($userStatement);
                $user = mysqli_fetch_assoc($userResult);

                echo "<div class='post'>";
                echo "<h2>" . $post['title'] . "</h2>";
                echo "<p>" . substr($post['post'], 0, 200) . "...</p>"; 
                echo "<a href='fullpost.php?post_id={$post['post_id']}'>Read more</a>";
                echo "<p>" . "Posted by " . "<b>" . "<a href='userprofile.php?user_id=" . $postUserId . "'>" . $user["full_name"] . "</a>" . "</b>" . " on " . $post["date_created"] . "</p>";
                echo "<hr>";
                echo "</div>";

            }
            ?> 

        </div>
        <footer>
            <p>&copy; 2023 Faruk Kurtić. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
