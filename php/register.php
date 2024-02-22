<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Register Page</title>
</head>
<?php
    //start or resume the session
    session_start();

    // Check if the user is already logged in, if yes then redirect to the welcome page
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("Location: ../php/index.php");
    exit();
    }


    // Establish the connection with the database
    require_once "dbconnect.php";

    // Define variables and initialize with empty values
    $username = $email = $password = $confirmPassword = "";
    $usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

    // Main code
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate the username
        if (empty(trim($_POST['username']))) {
            $usernameErr = "Please enter your username";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
            $usernameErr = "Username can only contain letters, numbers, and underscores.";
        } else {
            // Check if the username already exists
            $checkUsername = "SELECT id FROM users WHERE username = ?";
            $stmtCheck = mysqli_prepare($conn, $checkUsername);
            if (!$stmtCheck) {
                die("Error preparing statement: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmtCheck, "s", $param_username_check);
            $param_username_check = trim($_POST['username']);

            if (mysqli_stmt_execute($stmtCheck)) {
                //store result
                mysqli_stmt_store_result($stmtCheck);
                if (mysqli_stmt_num_rows($stmtCheck) > 0) {
                    $usernameErr = "This username is already taken.";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                die("Error executing statement: " . mysqli_error($conn));
            }

            mysqli_stmt_close($stmtCheck);
        }

        //validate the email
        if (empty(trim($_POST['email']))) {
            $emailErr = "Please enter your email";
        }
        else{
            $email = trim($_POST['email']);
            //check if email address is well-formed
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "Invalid email format";
            }
        }

        // Validate the password
        if (empty(trim($_POST['password']))) {
            $passwordErr = "Please enter a password";
        } elseif (strlen(trim($_POST['password'])) < 6) {
            $passwordErr = "Password must have at least 6 characters.";
        } else {
            $password = trim($_POST['password']);
        }

        // Validate confirm password
        if (empty(trim($_POST['confirmPassword']))) {
            $confirmPasswordErr = "Please confirm your password";
        } else {
            $confirmPassword = trim($_POST['confirmPassword']);
            if (empty($passwordErr) && ($password != $confirmPassword)) {
                $confirmPasswordErr = "Password did not match.";
            }
        }

        // Check input errors before inserting into the database
        if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
            // Prepare an insert statement
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

                // Set parameters
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Create a password hash

                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    //retirieve the user ID of the newly inserted user
                    $id = mysqli_insert_id($conn);
                    session_start();
                    //store the session id and username in session variable
                    $_SESSION["loggedin"] = true;
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;

                    // Redirect to the login page
                    header("Location: ../php/index.php");
                    exit();
                } else {
                    die("Error executing statement: " . mysqli_error($conn));
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                die("Error preparing statement: " . mysqli_error($conn));
            }
        }
        // Close the connection
        mysqli_close($conn);
    }
?>
<body>
    <?php
        include "../includes/header.php";
    ?>  
    <main>
        <div class="grid">
            <div class="left-container">
                <div class="title-desc">
                    <h1><span>Your Gateway</span> to<br> be one of us starts <br> here!</h1>
                    <p>Unlock the beat: Sign up now for exclusive <br> access and getting the full experience of <br> our community.</p>
                </div>
            </div>
            <div class="right-container">
                <div class="wrapper">
                    <h2>Create Account</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-group">
                            <span class="invalid-feedback"><?php echo $usernameErr;?></span>
                            <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($usernameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        </div>
                        <div class="form-group">
                            <span class="invalid-feedback"><?php echo $emailErr;?></span>
                            <input type="text" name="email" placeholder="Email address" class="form-control <?php echo (!empty($emailErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <span class="invalid-feedback"><?php echo $passwordErr;?></span>
                            <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>" value="">
                        </div>
                        <div class="form-group">
                            <span class="invalid-feedback"><?php echo $confirmPasswordErr;?></span>
                            <input type="password" name="confirmPassword" placeholder="Confirm password" class="form-control <?php echo (!empty($confirmPasswordErr)) ? 'is-invalid' : ''; ?>" value="">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="SIGN UP" class="submit-btn">
                            <p>Already have an account? <a href="login.php">Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php 
        include "../includes/footer.php";
    ?>
</body>
</html>