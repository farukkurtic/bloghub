<?php include "config/database.php"?>

<?php

session_start();

$user_id = $_GET["user_id"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
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
                        <a class="nav-link active" aria-current="page" href="profile.php">MY POSTS</a>
                        <a class="nav-link" href="newpost.php">NEW POST</a>
                        <a class="nav-link" href="blog.php">BLOG</a>
                        <a class="nav-link" href="logout.php">SIGN OUT</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="profile-main">
            <h1><?php echo $_SESSION["name"]?>'s posts</h1>
            <hr>

            <?php

                $posts_query = "SELECT * FROM posts WHERE user_id = ?";
                $statement = mysqli_prepare($connection, $posts_query);
                mysqli_stmt_bind_param($statement, "i", $user_id);
                mysqli_stmt_execute($statement);
                $post_result = mysqli_stmt_get_result($statement);

                $user_query = "SELECT full_name FROM users WHERE user_id = ?";
                $user_statement = mysqli_prepare($connection, $user_query);
                mysqli_stmt_bind_param($user_statement, "i", $user_id);
                mysqli_stmt_execute($user_statement);
                $user_result = mysqli_stmt_get_result($user_statement); // Use $user_statement here
                $user_row = mysqli_fetch_assoc($user_result);
                $username = $user_row["full_name"];

                if (mysqli_num_rows($post_result) > 0) {
                    while ($row = mysqli_fetch_assoc($post_result)) {
                        echo "<div class='post'>";
                        echo "<h2>" . $row['title'] . "</h2>";
                        echo "<p>" . $row['post'] . "</p>";
                        echo "<p>" . "Posted by " . "<b>" . $username . "</b>" . " on " . $row["date_created"] . "</p>";
                        echo "<hr>";
                        echo "</div>";
                    }
                } else {
                    // Prikazivanje teksta i animirane ikone ako objave ne postoje
                    echo "<div class='empty'>";
                    echo '<i class="fa-solid fa-bookmark fa-bounce fa-10x" style="color: #0099ff;"></i>';
                    echo '<h2 class="no-posts">No posts found</h2>';
                    echo "</div>";
                }

                // Free the result set
                mysqli_free_result($post_result);
                mysqli_free_result($user_result);
            
            ?>

        </div>
        <!-- footer -->
        <footer>
            <p>&copy; 2023 Faruk Kurtić. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>