<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/ticketDetails.css">
	<title>Ticket Details</title>
</head>
	<?php
		// Connect to the database (assuming $mysqli is your database connection)
		session_start();
		require("../php/dbconnect.php");
		include_once('../includes/header.php'); 

		// Initialize variables
		$row = []; // Initialize $row to an empty array
		$value = 1; // Default quantity is 1

		// Check if the ticket ID is provided in the URL
		if (isset($_GET["id"])) {
		    // Get the ticket ID from the URL
		    $ticket_id = $_GET["id"];

		    // Define SQL query to select ticket details based on the ticket ID
		    $query = "SELECT * FROM tickets WHERE ticket_id = $ticket_id";

		    // Execute the query
		    $result = mysqli_query($conn, $query);

		    // Check if the ticket exists in the database
		    if ($result->num_rows > 0) {
		        // Fetch ticket details
		        $row = $result->fetch_assoc();

		        // Use the full image path stored in the database
		        $full_image_path = $row["ticket_image_path"];
		        
		        // Find the position of the first occurrence of "/event_images" in the full path
		        $pos = strpos($full_image_path, "/event_images");
		        
		        // If "/event_images" is found, extract the substring starting from that position
		        // Otherwise, use the full path as is
		        $image_path = $pos !== false ? substr($full_image_path, $pos) : $full_image_path;
		        
		        // Output the image with the trimmed path
		        //echo "<img src='.." . $image_path . "' alt='" . $row["ticket_name"] . "'>";

		    } else {
		        echo "Ticket not found.";
		    }
		} else {
		    echo "Ticket ID not provided.";
		}

		// Handle quantity form submission
		if(isset($_POST['incqty'])){
		    $value = isset($_POST['item']) ? $_POST['item'] + 1 : 1; // Increment quantity
		}

		if(isset($_POST['decqty'])){
		    $value = max(1, isset($_POST['item']) ? $_POST['item'] - 1 : 1); // Decrement quantity, ensure it doesn't go below 1
		}

		// Close database connection
		mysqli_close($conn);
	?>
<body>
	<div class="grid-container">
		<div class="grid-wrapper">
			<div class="grid-item">
				<div class="grid-image">
					<?php echo "<img src='.." . $image_path . "' alt='" . $row["ticket_name"] . "'>"; ?>
				</div>
			</div>
			<div class="grid-desc">
				<div class="desc-details">
					<h1><?php echo $row["ticket_name"];?></h1>
					<p><?php echo $row["event_date"];?></p>
					<p><?php echo $row["event_time"];?></p>
					<p><?php echo $row["location"];?></p>
					<h3>RM 	<?php echo $row["ticket_price"];?></h3>

					<form method='POST'>
	                    <input type='hidden' name='item' value='<?= $value; ?>'/> <!-- Use hidden field to store the quantity -->
	                    <td>
							<span><p>Quantity</p></span>
							<div class="quantity">
								<button type="submit" name='decqty' class="quantity-btn">-</button>
								<input type='text' size='1' value="<?= $value; ?>" readonly /> <!-- Display the current quantity -->
								<button type="submit" name='incqty' class="quantity-btn">+</button>
							</div>
						</td>
					</form>
					
                    <form method='GET' action='../php/add-to-cart.php'>
                        <!-- Pass ticket ID as URL parameter -->
                        <input type='hidden' name='ticket_id' value='<?php echo $ticket_id; ?>'/>
                        <!-- Pass quantity as URL parameter -->
                        <input type='hidden' name='quantity' value='<?php echo $value; ?>'/>
                        <button class="cartBtn" name="add-to-cart">
						  <svg class="cart" fill="white" viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
						  ADD TO CART
						  <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" class="product"><path d="M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0h12.6c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7V448c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V197.7l-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0h12.6z"></path></svg>
						</button>
						
                    </form>						
				</div>	
			</div>
		</div>
	</div>
	
	<?php
		include_once("../includes/footer.php");
	?>
</body>
</html>