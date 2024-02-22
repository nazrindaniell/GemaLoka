<?php
    require_once "dbconnect.php";
    session_start();

    //define variables and initialize with empty values
    $name = $email = $subject = $message = "";
    $nameErr = $emailErr = $subjectErr = $messageErr = "";

    //check if the user is logged in
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            //validate name
            if(empty(trim($_POST['name']))){
                $nameErr = "Name is required";
            }
            else{
                $name = $_POST['name'];
            }

            //validate email
            if(empty(trim($_POST['email']))){
                $emailErr = "Email is required";
            }
            else{
                $email = trim($_POST['email']);
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $emailErr = "Invalid email format";
                }
            }

            //validate subject
            if(empty($_POST['subject'])){
                $subjectErr = "Subject is required";
            }
            else{
                $subject = $_POST['subject'];
            }

            //validate message
            if(empty($_POST['message'])){
                $messageErr = "Message is required";
            }
            else{
                $message = $_POST['message'];
            }

            //check input errors before inserting into the database
            if(empty($nameErr) && empty($emailErr) && empty($subjectErr) && empty($messageErr)){
                // Create a prepared statement
                $stmtQuery = "INSERT INTO form (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $stmtQuery);

                // Bind parameters
                mysqli_stmt_bind_param($stmt, "issss", $user_id, $name, $email, $subject, $message);

                // Execute the statement
                if(mysqli_stmt_execute($stmt)) {
                    echo "Form submitted successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            }
        }
        //close the connection
        mysqli_close($conn);
    }
    else{
        //user is not logged in
        //redirect to login page
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(!isset($_SESSION['id'])){
                header("Location: ../php/login.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Contact us Page</title>
</head>
<body>
    <?php
        include_once("../includes/header.php");
    ?>
    <div class="contact-container-2">
        <div class="contact-wrapper">
            <div class="contact-left">
                <div class="contact-title">
                    <h1>Get in Touch</h1>
                    <p>Your feedback is invaluable to us. Whether you have a question, suggestion, or just want to connect, we're here to listen. Simply fill out the form provided, and our dedicated team will be in touch with you promptly. We look forward to hearing from you and building a meaningful relationship together.</p>    
                </div>
                <div class="contact-information">
                    <div class="phone">
                        <i class='bx bx-phone bx-lg'></i>
                        <p>+60123456789</p>
                    </div>
                    <div class="email">
                        <i class='bx bx-envelope bx-lg'></i>
                        <p>gemaloka@gmail.com</p>
                    </div>
                </div>
                <div class="follow-us">
                    <h4>Follow us on</h4>
                    <div class="icons">
                        <i class='bx bxl-instagram-alt'></i>
                        <i class='bx bxl-facebook-circle'></i>
                        <i class='bx bxl-twitter'></i>
                    </div>
                </div>
            </div>
            <div class="contact-right">
                <div class="wrapper">
                    <h2>Send a Message</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Name <span class="invalid-feedback"><?php echo $nameErr;?></span></label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($nameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="invalid-feedback"><?php echo $emailErr;?></span></label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($emailErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject <span class="invalid-feedback"><?php echo $subjectErr;?></span></label>
                            <input type="text" name="subject" class="form-control <?php echo (!empty($subjectErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject; ?>">
                        </div>
                        <div class="form-group">
                            <label for="Message">Message <span class="invalid-feedback"><?php echo $messageErr;?></span></label>
                            <input type="text" name="message" class="form-control <?php echo (!empty($messageErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $message; ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="submit-btn" value="send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        require_once("../includes/footer.php");
    ?>
</body>
</html>
