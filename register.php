<?php include "config/database.php"?>

<?php

if(isset($_POST["submit"])) {

    $full_name = $email = $password = "";
    $full_name_err = $email_err = $password_err = $password_repeat_err = "";
    
    if(empty($_POST["full_name"])) {
        $full_name_err = "Full Name can't be empty";
    };

    if(empty($_POST["email"])) {
        $email_err = "Email can't be empty";
    };

    if(empty($_POST["password"])) {
        $password_err = "Password can't be empty";
    };

    if(empty($_POST["password_repeat"])) {
        $password_repeat_err = "Password repeat can't be empty";
    };

    $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    if($email_err != "Email can't be empty") {
        if (!preg_match($pattern, $_POST["email"])) {
            $email_err = "Email is not in the correct format";
        }
    };

    $password_pattern = '/^(?=.*[0-9])(?=.*[^\w\s]).{8,}$/';
    if($password_err != "Password can't be empty") {
        if (!preg_match($password_pattern, $_POST["password"])) {
            $password_err = "Password must have at least 8 characters and contain at least one number and one symbol";
        }
    };

    if($password_err != "Password can't be empty" && $password_repeat_err != "Password repeat can't be empty") {
        if($_POST["password"] != $_POST["password_repeat"]) {
            $password_repeat_err = "Passwords do not match";
        }
    };
i
    if($full_name_err == "" && $email_err == "" && $password_err == "" && $password_repeat_err == "" ) {

        $full_name = filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $check_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($connection, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {

            echo "
            <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
            <script>
            $(document).ready(function() {
                $('#userExistsModal').modal('show');
            });
          </script> ";
        } else {
            $sql = "INSERT INTO `users` (`full_name`, `email`, `password`) VALUES ('$full_name', '$email', '$password_hash')";
            if(mysqli_query($connection, $sql)) {
                
                $session_query = "SELECT * FROM users WHERE email = '$email'";
                $session_result = mysqli_query($connection, $session_query);
                $row = mysqli_fetch_assoc($session_result);

                session_start();
                $_SESSION["name"] = $full_name;
                $_SESSION["email"] = $email;
                $_SESSION["id"] = $row["user_id"];
                header("Location: profile.php"); 

              } else {

                echo "error";

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
                        <a class="nav-link active" aria-current="page" href="register.php">SIGN UP</a>
                        <a class="nav-link" href="login.php">LOG IN</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="row text-row">
            <div class="col-lg-7">
                <h1 class="text-heading">Sign up <br> today to <br><span id="typed"></span></h1>
            </div>  
            <div class="col-lg form-row">
                <form class="forma-registracija" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="col forma">
                        <div class="row">
                            <div class="mb-3">
                                <label for="registrationName" class="form-label">Full Name</label>
                                <input type="text" class="form-control <?php echo $full_name_err != "" ? "is-invalid" : null; ?>" id="registrationName" aria-describedby="emailHelp" name="full_name">
                                <div class="invalid-feedback">
                                    <?php echo $full_name_err ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="registrationEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control <?php echo $email_err != "" ? "is-invalid" : null; ?>" id="registrationEmail" aria-describedby="emailHelp" name="email">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                <div class="invalid-feedback">
                                    <?php echo $email_err ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="mb-3 col">
                                <label for="registrationPassword" class="form-label">Password</label>
                                <input type="password" class="form-control <?php echo $password_err != "" ? "is-invalid" : null; ?>" id="registrationPassword" name="password">
                                <div class="invalid-feedback">
                                    <?php echo $password_err ?>
                                </div>
                            </div>
                            <div class="mb-3 col">
                                <label for="registrationRepeat" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control <?php echo $password_repeat_err != "" ? "is-invalid" : null; ?>" id="registrationRepeat" name="password_repeat">
                                <div class="invalid-feedback">
                                    <?php echo $password_repeat_err ?>
                                </div>
                            </div>
                            <button type="submit" class="btn registration-btn" name="submit" value="submitted">Sign up</button>
                            <p>Already a member? Log in <a href="login.php">here</a></p>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
        <div class="modal fade" id="userExistsModal" tabindex="-1" role="dialog" aria-labelledby="userExistsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userExistsModalLabel">User Already Exists</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A user with the provided email already exists. Please choose a different email or try logging in.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var typed = new Typed('#typed', {
        strings: ['share', 'discover' ,'connect'],
        typeSpeed: 50,
        loop: true
        });
  </script>
</body>
</html>
