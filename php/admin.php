<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Page</title>
</head>
<?php
	require_once "../php/dbconnect.php";
	session_start();
	/*
		BRIEF FOR ADMIN PAGE
		1) all non and registered users can view the ticket's page
		2) admin can add the event ticket to the database to let the viewer see it in the ticket page
	*/
		// Check if form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		    // Connect to the database (assuming $mysqli is your database connection)

		    // Process form data
		    $ticket_name = $_POST["ticket_name"];
		    $event_date = $_POST["event_date"];
		    $event_time = $_POST["event_time"];
		    $location = $_POST["location"];

		    // Check if a file is uploaded
		    if (isset($_FILES["ticket_image"]) && !empty($_FILES["ticket_image"]["tmp_name"])) {
		        // Specify the target directory
		        $target_dir = "C:/xampp/htdocs/EventOrganizerWebsite/event_images/";

		        // Generate a unique filename to avoid overwriting existing files
		        $target_file = $target_dir . uniqid() . '_' . basename($_FILES["ticket_image"]["name"]);

		        // Move the uploaded file to the target directory
		        if (move_uploaded_file($_FILES["ticket_image"]["tmp_name"], $target_file)) {
		            // Insert ticket into database with the image file path
		            $query = "INSERT INTO tickets (ticket_name, event_date, event_time, location, ticket_image_path) 
		                      VALUES ('$ticket_name', '$event_date', '$event_time', '$location', '$target_file')";
		            $result = mysqli_query($conn, $query);

		            if ($result) {
		                echo "Ticket added successfully!";
		            } else {
		                echo "Error: " . mysqli_error();
		            }
		        } else {
		            echo "Error uploading file.";
		        }
		    } else {
		        echo "No file uploaded.";
		    }

		    // Close database connection
		    mysqli_close($conn);
		}
 	
?>
<body>
	<h1>admin page</h1>
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
		<label for="ticket_name">Ticket Name:</label>
		<input type="text" name="ticket_name" required><br>
		<label for="event_date">Event Date:</label>
		<input type="text" name="event_date" required><br>
		<label for="event_time">Event Time:</label>
		<input type="text" name="event_time" required><br>
		<label for="location">Location:</label>
		<input type="text" name="location" required><br>
		<label for="ticket_image">Ticket Image:</label>
		<input type="file" id="ticket_image" name="ticket_image" accept="image/*" required><br>
		<input type="submit" value="Add Ticket">
	</form>
</body>
</html>