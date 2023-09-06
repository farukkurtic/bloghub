<?php include "config/database.php"?>

<?php 

session_start();

$old_post_title = $old_post_content = "";

if (isset($_GET["post_id"])) {

    $post_id = $_GET["post_id"];

    // izvlacenje stare objave
    $old_query = "SELECT * FROM posts WHERE post_id = ?";
    $old_statement = mysqli_prepare($connection, $old_query);
    mysqli_stmt_bind_param($old_statement, "i", $post_id);
    mysqli_stmt_execute($old_statement);
    $result = mysqli_stmt_get_result($old_statement);
    $row = mysqli_fetch_assoc($result);

    $old_post_title = $row['title'];
    $old_post_content = $row['post'];

}

if(isset($_POST["submit"])) {
    $newTitle = $newContent = "";
    $newTitle_err = $newContent_err = "";

    if(empty($_POST["post_title"])) {
        $newTitle_err = "Post title can't be empty";
    };
    if(empty($_POST["post_content"])) {
        $newContent_err = "Post content can't be empty";
    };

    if($newTitle_err == "" && $newContent_err == "") {

        $newTitle = filter_input(INPUT_POST, "post_title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $newPost = htmlspecialchars($_POST["post_content"], ENT_QUOTES, 'UTF-8');

        $query = "UPDATE posts SET title = ?, post = ? WHERE post_id = ?";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, "ssi", $newTitle, $newPost, $post_id);
        mysqli_stmt_execute($statement);

        if (mysqli_stmt_affected_rows($statement) > 0) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Post update failed";
        }
    };
}

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
                        <a class="nav-link" href="newpost.php">NEW POST</a>
                        <a class="nav-link" href="logout.php">SIGN OUT</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- forma za editovanje objave -->
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?post_id=' . $_GET['post_id']; ?>" method="POST" class="post-forma">
            <div class="mb-3">
                <label for="titleEdit" class="form-label">Post Title</label>
                <input type="text" class="form-control <?php echo $newTitle_err != "" ? "is-invalid" : null; ?>" id="postEdit" name="post_title" value="<?php echo $old_post_title; ?>">
                <div class="invalid-feedback">
                    <?php echo !empty($newTitle_err) && empty($old_post_title) ? $newTitle_err : ''; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="postContent" class="form-label">Post Content</label>
                <textarea class="form-control <?php echo $newContent_err != "" ? "is-invalid" : null; ?>" id="postContent" rows="10" name="post_content"><?php echo $old_post_content; ?></textarea>
                <div class="invalid-feedback">
                    <?php echo !empty($newContent_err) && empty($old_post_content) ? $newContent_err : ''; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg" name="submit" value="submitted">Submit</button>
        </form>
        <!-- footer -->
        <footer>
            <p>&copy; 2023 Faruk Kurtić. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>