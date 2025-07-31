<?php include "config/database.php"?>

<?php

$email = $password = "";
$email_err = $password_err = "";

if(isset($_POST["submit"])) {

    if(empty($_POST["email"])) {
        $email_err = "Email can't be empty";
    };

    if(empty($_POST["password"])) {
        $password_err = "Password can't be empty";
    };

    if($email_err == "" && $password_err == "") {

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email_query = "SELECT * FROM users WHERE email = '$email'";
        $email_result = mysqli_query($connection, $email_query);

        if(mysqli_num_rows($email_result) === 0) {
            echo "
            <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
            <script>
            $(document).ready(function() {
                $('#userExistsModal').modal('show');
            });
          </script> ";
        } else {
            $row = mysqli_fetch_assoc($email_result);
            $password_hash = $row["password"];

            if(password_verify($password, $password_hash)) {
                session_start();
                $_SESSION["name"] = $row["full_name"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["id"] = $row["user_id"];
                header("Location: profile.php");
            } else {
                $password_err = "Email and password combination does not exist.";
            }
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
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <link rel="stylesheet" href="./styles/style.css">
    <title>Sign up</title>
</head>
<body class="register-body">

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">BLOGHUB</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" aria-current="page" href="register.php">SIGN UP</a>
                        <a class="nav-link active" href="login.php">LOG IN</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="row text-row">
            <div class="col-lg-7">
                <h1 class="text-heading-login"><span class="heading-span">Welcome!</span>We're glad <br> to have you back.</h1>
            </div>  
            <div class="col-lg form-row">
                <form class="forma-registracija" method="post">
                    <div class="col forma">
                        <div class="row">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control <?php echo $email_err != "" ? "is-invalid" : null; ?>" id="loginEmail" name="email" aria-describedby="emailHelp">
                                <div class="invalid-feedback">
                                    <?php echo $email_err ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="mb-3 col">
                                <label for="loginPassword" class="form-label">Password</label>
                                <input type="password" class="form-control <?php echo $password_err != "" ? "is-invalid" : null; ?>" name="password" id="loginPassword">
                                <div class="invalid-feedback">
                                    <?php echo $password_err ?>
                                </div>
                            </div>
                            <button type="submit" class="btn registration-btn" name="submit" value="submitted">Log in</button>
                            <p>Not a member yet? Sign up <a href="register.php">here</a></p>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
        <div class="modal fade" id="userExistsModal" tabindex="-1" role="dialog" aria-labelledby="userExistsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userExistsModalLabel">User not found</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A user with the provided email does not exists. Please choose a different email or sign up.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
