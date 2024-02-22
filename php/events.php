<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/events.css">
	<title>Featured Events</title>
</head>
<body>
	<?php
		session_start();
		require("../php/dbconnect.php");
		include_once('../includes/header.php'); 

		// Define SQL query to select ticket details
		$query = "SELECT * FROM tickets";
		// Execute the query
		$result = mysqli_query($conn,$query);
	?>

	<div class="grid-container"> <!-- Featured events section -->
		<div class="grid-title">
			<h1>Featured Events</h1>
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
		?>
	</div>
	<?php
		include_once("../includes/footer.php");
	?>
</body>
</html>