<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/add-to-cart.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>View Cart</title>
</head>
<body>
<?php
    // Start or resume the session
    session_start();

    // Connect to the database
    require("../php/dbconnect.php");
    include_once('../includes/header.php');

    // Function to calculate cart total with discount
    function calculateTotalWithDiscount($total, $is_subscribed) {
        if($is_subscribed) {
            $discount = $total * 0.1; // 10% discount for subscribed users
            return [$total - $discount, $discount]; // Return total and discount amount
        } else {
            return [$total, 0]; // No discount for non-subscribed users
        }
    }

    // Check if the user is logged in
    if(isset($_SESSION['id'])) {
        // Retrieve username and email from the database
        $user_id = $_SESSION['id'];
        $query = "SELECT username, email FROM users WHERE id = $user_id";
        $result = mysqli_query($conn, $query);
        $user_row = mysqli_fetch_assoc($result);
        $username = $user_row['username'];
        $email = $user_row['email'];

        // Check if the ticket ID and quantity are provided in the URL parameters
        if(isset($_GET['ticket_id']) && isset($_GET['quantity'])) {
            // Get the ticket ID and quantity from the URL parameters
            $ticket_id = $_GET['ticket_id'];
            $quantity = $_GET['quantity'];

            // Query the database to fetch ticket details
            $query = "SELECT * FROM tickets WHERE ticket_id = $ticket_id";
            $result = mysqli_query($conn, $query);

            // Check if the ticket exists
            if(mysqli_num_rows($result) > 0) {
                // Fetch ticket details
                $ticket_row = mysqli_fetch_assoc($result);

                // Use the full image path stored in the database
                $full_image_path = $ticket_row["ticket_image_path"];
                    
                // Find the position of the first occurrence of "/event_images" in the full path
                $pos = strpos($full_image_path, "/event_images");
                    
                // If "/event_images" is found, extract the substring starting from that position
                // Otherwise, use the full path as is
                $image_path = $pos !== false ? substr($full_image_path, $pos) : $full_image_path;
                
                // Calculate total price
                $total_price = $ticket_row['ticket_price'] * $quantity;

                // Check if the ticket already exists in the user's cart
                $check_query = "SELECT * FROM cart WHERE user_id = {$_SESSION['id']} AND ticket_id = $ticket_id";
                $check_result = mysqli_query($conn, $check_query);

                if(mysqli_num_rows($check_result) > 0) {
                    // Ticket already exists in the cart, update the quantity
                    $existing_cart_item = mysqli_fetch_assoc($check_result);
                    $new_quantity = $existing_cart_item['quantity'] + $quantity;
                    $update_query = "UPDATE cart SET quantity = $new_quantity, total = price * $new_quantity WHERE id = {$existing_cart_item['id']}";
                    if(mysqli_query($conn, $update_query)) {
                        // Quantity updated successfully
                        header("Location: ../php/ticketDetails.php?id=$ticket_id");
                        exit;
                    } else {
                        echo "Error updating quantity: " . mysqli_error($conn);
                    }
                } else {
                    // Insert cart item into the database
                    $insert_query = "INSERT INTO cart (user_id, ticket_id, quantity, price, total, ticket_image_path) 
                                    VALUES ({$_SESSION['id']}, $ticket_id, $quantity, {$ticket_row['ticket_price']}, $total_price, '$image_path')";
                    if(mysqli_query($conn, $insert_query)) {
                        // Cart item inserted successfully
                        header("Location: ../php/ticketDetails.php?id=$ticket_id");
                        exit;
                    } else {
                        echo "Error inserting cart item: " . mysqli_error($conn);
                    }
                }

            } 
            else {
                echo "Ticket not found.";
            }
        }

        // Check if the form is submitted for updating quantities or deleting items
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Update quantities if form data is provided
            if(isset($_POST['quantities']) && is_array($_POST['quantities'])) {
                foreach($_POST['quantities'] as $id => $quantity) {
                    // Validate quantity (e.g., ensure it's a positive integer)
                    // Update cart item quantity in database
                    $quantity = intval($quantity);
                    $update_query = "UPDATE cart SET quantity = $quantity WHERE id = $id";
                    mysqli_query($conn, $update_query);
                }
            }
            // Delete items if delete button is clicked
            if(isset($_POST['delete']) && is_array($_POST['delete'])) {
                foreach($_POST['delete'] as $id => $value) {
                    // Delete cart item from database
                    $delete_query = "DELETE FROM cart WHERE id = $id";
                    mysqli_query($conn, $delete_query);
                }
            }
        }

        // Initialize cart total and discount variables
        $cart_total = 0;
        $discount = 0;

        // Retrieve user's subscription status from the database
        $user_id = $_SESSION['id'];
        $query = "SELECT is_subscribed FROM users WHERE id = $user_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $is_subscribed = $row['is_subscribed'];

        // Retrieve cart items for the logged-in user from the database
        $query = "SELECT * FROM cart WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);

        // Check if cart items exist for the user
        if(mysqli_num_rows($result) > 0){
?>
            <div class="grid">
                <div class="left-container">
                    <div class="left-title">
                        <h2>Shopping Cart</h2>
                    </div>
                    <div class="left-wrapper">
                        <div class="item">
                            <div class="item-wrapper">
                                <p>Ticket</p>
                                <p>Quantity</p>
                                <p>Price</p>
                                <p>Total</p>
                            </div>
                        </div>
                        <!-- Display the cart -->
                        <form method='POST' class="form-item">
                        <?php
                            while($row=mysqli_fetch_assoc($result)){
                                //calculate total price for each item
                                $item_total = $row['quantity'] * $row['price'];
                                $cart_total += $item_total;
                        ?>
                            <div class="item">
                                <div class="item-wrapper">
                                    <img src="<?php echo '..' . $row['ticket_image_path']; ?>" />
                                    <!-- Replace the input field with styled number input -->
                                    <div class="quantity">
                                        <input type="number" name="quantities[<?php echo $row['id']; ?>]" value="<?php echo $row['quantity']; ?>" min="1">
                                    </div>

                                    <!--<input type="number" name="quantities[<?php echo $row['id']; ?>]" value="<?php echo $row['quantity']; ?>" min="1">-->
                                    <p>RM <?php echo $row['price']; ?></p>
                                    <p>RM <?php echo $row['quantity'] * $row['price']; ?></p>
                                    <button type="submit" name="delete[<?php echo $row['id']; ?>]"><i class='bx bx-x'></i></button>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                            <button id="bottone3">Update</button>
                        </form>
                    </div>
                </div>

                <div class="right-container">
                    <div class="right-wrapper">
                        <div class="information">
                            <h2>Order Summary</h2>
                            <h4><?php echo $username; ?></h4>
                            <p><?php echo $email; ?></p>
                        </div>
                        <?php if($is_subscribed):
                            list($final_total, $discount) = calculateTotalWithDiscount($cart_total, true); 
                        ?>
                        <div class="calc">
                            <!-- order summary content -->
                            <div class="cart-total">
                                <div class="cart-desc">
                                    <p>Cart Total</p>    
                                </div>
                                <div class="cart-price">
                                    <h3>RM <?php echo $cart_total; ?></h3>    
                                </div>
                            </div>
                            <div class="discount">
                                <div class="cart-desc">
                                    <p>Membership</p>   
                                </div>
                                <div class="cart-price">
                                    <h3>-RM <?php echo $discount; ?></h3> 
                                </div>
                            </div>
                            <div class="final-total">
                                <div class="cart-desc">
                                    <p>Order Total</p> 
                                </div>
                                <div class="cart-price">
                                    <h3>RM <?php echo $final_total; ?></h3>
                                </div>
                            </div>
                            <a href="../php/checkout-splash-screen.php">
                                <button id="bottone1">Proceed to Checkout</button>
                            </a>
                        </div>
                    </div>
                </div>
                        <?php else: 
                            list($final_total, $discount) = calculateTotalWithDiscount($cart_total, false); 
                        ?>
                            <div class="calc">
                                <div class="cart-total">
                                    <div class="cart-desc">
                                        <p>Cart Total</p>    
                                    </div>
                                    <div class="cart-price">
                                        <h3>RM <?php echo $cart_total; ?></h3>    
                                    </div>
                                </div>

                                <div class="final-total">
                                    <div class="cart-desc">
                                        <p>Order Total</p> 
                                    </div>
                                    <div class="cart-price">
                                        <h3>RM <?php echo $final_total; ?></h3>
                                    </div>
                                </div>
                                <a href="../php/checkout-splash-screen.php">
                                    <button id="bottone1">Proceed to Checkout</button>
                                </a>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
        } 
        else {
?>            
        <div class="grid">
            <div class="left-container">
                <div class="left-title">
                    <h2>Shopping Cart</h2>
                </div>
                <div class="left-wrapper">
                    <div class="item">
                        <div class="item-wrapper">
                            <p>Ticket</p>
                            <p>Quantity</p>
                            <p>Price</p>
                            <p>Total</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-container">
                <div class="right-wrapper">
                    <div class="information">
                        <h2>Order Summary</h2>
                        <h4><?php echo $username; ?></h4>
                        <p><?php echo $email; ?></p>
                    </div>
                </div>
            </div>
        </div>
<?php
        }

        // Close database connection
        mysqli_close($conn);
    } 
    else {
        // If user is not logged in, redirect to the login page
        header("Location: ../php/login.php");
        exit;
    }

?>
<?php
    include_once ("../includes/footer.php");
?>

</body>
</html>
