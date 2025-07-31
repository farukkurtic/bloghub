<?php include "config/database.php"?>

<?php

session_start();
$user_id = $_SESSION["id"];

$newtitle = $newpost = "";
$newtitle_err = $newpost_err = "";

if(isset($_POST["submit"])) {
    
    if(empty($_POST["post_content"])) {
        $newpost_err = "Post content can't be empty";
    };

    if(empty($_POST["post_title"])) {
        $newtitle_err = "Post title can't be empty";
    };

    if($newpost_err == "" && $newtitle_err == "") {

        $newtitle = filter_input(INPUT_POST, "post_title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $newpost = htmlspecialchars($_POST["post_content"], ENT_QUOTES, 'UTF-8');

        $query = "INSERT INTO posts (title, post, user_id) VALUES (?, ?, ?)";
        $statement = mysqli_prepare($connection, $query);


        mysqli_stmt_bind_param($statement, "ssi", $newtitle, $newpost, $user_id);
        mysqli_stmt_execute($statement);

        if (mysqli_stmt_affected_rows($statement) > 0) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Post creation failed";
        }

    }
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
    <title>New post</title>
</head>
<body class="newpost-body">
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
                        <a class="nav-link active" href="newpost.php">NEW POST</a>
                        <a class="nav-link" href="blog.php">BLOG</a>
                        <a class="nav-link" href="logout.php">SIGN OUT</a>
                    </div>
                </div>
            </div>
        </nav>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="post-forma">
        <h1>What's on your mind?</h1>
            <div class="mb-3">
                <label for="postTitle" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="postTitle" aria-describedby="emailHelp" name="post_title">
            </div>
            <div class="mb-3">
                <label for="postContent" class="form-label">Post Content</label>
                <textarea class="form-control" id="postContent" rows="10" name="post_content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg" name="submit" value="submitted">Post</button>
        </form>
    </div>
</body>
</html>
