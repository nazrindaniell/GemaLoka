<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect to the welcome page
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("Location: ../php/index.php");
    exit();
}

// Include the database connection file
require_once "dbconnect.php";

// Define the variable and initialize with empty values
$username = $password = "";
$usernameErr = $passwordErr = $loginErr = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $usernameErr = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $passwordErr = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($usernameErr) && empty($passwordErr)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("Location: ../php/index.php");
                            exit();
                        } 
                        else{
                            // Password is not valid, display a generic error message
                            $loginErr = "Invalid username or password.";
                        }
                    }
                } 
                else{
                    // Username doesn't exist, display a generic error message
                    $loginErr = "Invalid username or password.";
                }
            } 
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <title>Login Page</title>
</head>

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
                <h2>Sign in to GemaLoka</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <span class="invalid-feedback"><?php echo $usernameErr;?></span>
                        <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($usernameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                        <span class="invalid-feedback"><?php echo $passwordErr;?></span>
                        <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="SIGN IN" class="submit-btn">
                        <p>Don't have an account? <a href="../php/register.php">Sign up</a></p>
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
