<?php
// Start or resume the session
session_start();

// Connect to the database
require("../php/dbconnect.php");
include_once('../includes/header.php');

// Check if the user is logged in
if(isset($_SESSION['id'])) {
    // Check if the subscription form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['purchase'])) {
        // Update user's subscription status in the database
        $user_id = $_SESSION['id'];
        $update_query = "UPDATE users SET is_subscribed = TRUE WHERE id = $user_id";
        if(mysqli_query($conn, $update_query)) {
            echo "<p class='success-msg'><span>Success!</span> Subscription successful!</p>";
        } else {
            echo "<p class='error-msg'>Error subscribing: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    // If user is not logged in, redirect to the login page
    header("Location: ../php/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/subscription.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Subscription Page</title>
</head>
<body>
    <div class="container">
        <div class="container-title">
            <h1>GemaLoka Membership</h1>
            <div class="grid">
                <div class="left-grid">
                    <div class="left-grid-wrapper">
                        <p>Your music, our platform, connected.</p>
                        <h2>Experience More, <span>Pay Less</span></h2>
                        <div class="item-wrapper">
                            <div class="item">
                                <i class='bx bxs-check-circle'></i>
                                <div class="item-desc">
                                    <h4>Exclusive savings</h4>
                                    <p>Enjoy a 10% discount on every purchase</p>
                                </div>
                            </div>
                            <div class="item">
                                <i class='bx bxs-check-circle'></i>
                                <div class="item-desc">
                                    <h4>Year-round discount</h4>
                                    <p>Eligible on concerts, festivals, and special events.</p>
                                </div>
                            </div>
                            <div class="item">
                                <i class='bx bxs-check-circle'></i>
                                <div class="item-desc">
                                    <h4>Join today with a click</h4>
                                    <p>Subscription is only one-click away and hassle free.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-grid">
                    <div class="right-grid-wrapper">
                        <div class="box">
                            <div class="price">
                                <h2>RM 15</h2>
                                <p>/year</p>
                            </div>
                            <p>Enjoy 10% discount for every purchase</p>
                            <h4>Cancel anytime</h4>
                        </div>
                        <form method="POST">
                            <div class="purchase-btn">
                                <input type="submit" name="purchase" value="Purchase">
                            </div>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    include_once("../includes/footer.php");
?>
</html>
