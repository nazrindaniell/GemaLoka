<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <nav> <!-- This is nav bar section -->
        <div>
            <a href="../php/index.php"><h2>GemaLoka</h2></a>
        </div>
        <div class="navbar-links">
            <ul>
                <li><a href="../php/index.php">Home</a></li>
                <li><a href="../php/events.php">Event</a></li>
                <li><a href="../php/subscription.php">Subscription</a></li>
                <li><a href="../php/about.php">About</a></li>
                <li><a href="../php/contact.php">Contact</a></li>
            </ul>
        </div>
        <div class="container-btn">
            <div class="view-cart">
                <a href="../php/add-to-cart.php"><i class='bx bx-shopping-bag'></i></a>
            </div>
            <p class="signup-btn">
                <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                        echo htmlspecialchars($_SESSION['username']);
                    }
                    else{
                        echo "<a href='../php/register.php'>Sign Up</a>";
                    }
                ?>
            </p>
            <div class="logout">
                <a href="../php/logout.php"><i class='bx bx-log-out-circle'></i></a>
            </div>
        </div>
    </nav>
</body>
</html>
