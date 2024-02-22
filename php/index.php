<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Event Organizer Website</title>
	<link rel="stylesheet" href="../css/index.css">
</head>
<body>
	<?php 
		session_start();
		require("../php/dbconnect.php");
		include_once('../includes/header.php'); 

		// Define SQL query to select ticket details
		$query = "SELECT * FROM tickets LIMIT 4";
		// Execute the query
		$result = mysqli_query($conn,$query); 
	?>
	
	<div class="main-container">
		<video autoplay muted loop plays-inline class="back-video">
			<source src="../videos/concert.mp4" type="video/mp4"> <!-- this is the homepage background -->
		</video>
		<div class="content">
			<h1>GemaLoka: Your Gateway to <br>Homegrown Melodies</h1>
			<p>We strive to provide a platform for emerging local talent, giving them the <br> spotlight they deserve and showcasing the diversity of our music scene.</p>
		</div>
		<a href="../php/about.php">
			<button id="bottone2">Learn More</button>
		</a>
	</div>


	<div class="grid-container"> <!-- Upcoming events section -->
		<div class="grid-title">
			<h1>Upcoming Events</h1>
		</div>
		<div class="grid-wrapper">
			<?php
				while ($row = $result->fetch_assoc()) {
					// Use the full image path stored in the database
			        $full_image_path = $row["ticket_image_path"];
			        
			        // Find the position of the first occurrence of "/event_images" in the full path
			        $pos = strpos($full_image_path, "/event_images");
			        
			        // If "/event_images" is found, extract the substring starting from that position
			        // Otherwise, use the full path as is
			        $image_path = $pos !== false ? substr($full_image_path, $pos) : $full_image_path;
			?>
			<div class="grid-item">
				<?php echo "<a href='../php/ticketDetails.php?id=" . $row["ticket_id"] . "'>";?>
					<div class="grid-image">
						<?php echo "<img src='.." . $image_path . "' alt='" . $row["ticket_name"] . "'>";?>
					</div>
					<div class="grid-desc">
						<h3><?php echo $row["ticket_name"];?></h3>
						<p><?php echo $row["event_date"];?></p>
						<p><?php echo $row["event_time"];?></p>
						<p><?php echo $row["location"];?></p>
					</div>
				</a>  	
			</div>
			<?php
				}
			?>
		</div>
		<a href="../php/events.php">
			<button id="bottone1">View More</button>
		</a>
		?>
	</div> 

	<div class="membership-container"> <!-- GemaLoka membership section -->
		<div class="membership-item">
			<h2>Subscribe to GemaLoka <br>Membership</h2>
			<p>Your passport to an exciting experience begins with only RM 15 a year,<br> unlock an exclusive realm where rhythm 
					meets savings. Our subscribers<br> enjoys a fantastic 10% discount on every event ticket, ensuring that your<br> musical 
					adventures are not only unforgettable but also budget friendly.<br> Join our community, subscribe today and ready to 
					take the plunge into<br> GemaLoka.</p>
		<div class="membership-btn">
			<a href="../php/subscription.php">
				<button id="bottone1">Subscribe Now</button>
			</a>
		</div>
		</div>
	</div>

	<div class="newsletter-container"> <!-- Newsletter section -->
		<div class="newsletter-wrapper"> 
			<div class="newsletter-left">
				<h2>Newsletter</h2>
				<p>Subscribe to the GemaLoka newsletter - <br> to get notify on every upcoming events</p>
			</div>
			<div class="newsletter-right">
				<label for="email">Your email address</label>
				<input type="email" id="email" name="email">
				<a href="#">
					<button id="bottone3">Sign Up</button>
				</a>
			</div>
		</div>
	</div>
	
	<?php
		include_once('../includes/footer.php');
	?>
</body>
</html>