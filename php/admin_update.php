<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Update Information</title>
</head>
<body>
    <?php //open php 1
        require_once "../php/dbconnect.php";
    ?> <!-- close php 1 -->
    <div class="chooseContainer">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <header>Select ticket to update information</header>
            <select name="registered">  <!--This is the drop-down menu to select the name to edit-->
                <?php //open php 2
                    $query = "SELECT ticket_id, ticket_name FROM tickets ORDER BY ticket_name ASC";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row=mysqli_fetch_assoc($result)){
                            ?>
                            <option value="<?php echo $row['ticket_id']; ?>"><?php echo $row['ticket_name']?></option>
                            <?php
                        }
                    }
                    else{
                        echo "There is no ticket yet.";
                    }
                ?> <!-- close php 2 -->
            </select> <!-- This is the end of the drop-down menu -->
            <br>
            <input type="submit" name="choose" value="Choose" class="btn">
        </form>
    </div>
    <?php //open php 3
        if(isset($_POST['choose']) && $_POST['choose'] != ""){
            $chosen = $_POST['registered'];
            $query = "SELECT * FROM tickets WHERE ticket_id = '$chosen'";
            $result = mysqli_query($conn, $query);
            $resultId = "The id number of the chosen person is $chosen";
            ?> <!-- close php 3 -->
            <div class="container">
                <div class="box form-box">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <header><?php echo $resultId?></header>
                        <input type="hidden" name="id" value="<?php echo $chosen; ?>">
                        <?php //open php 4
                        while ($row=mysqli_fetch_assoc($result)) {
                        ?> <!-- close php 4 -->
                        <div class="field input">
                            <label for="ticket_name">Ticket Name:</label>
                            <input type="text" name="ticket_name" value="<?php echo $row['ticket_name']; ?>">
                        </div>
                        <div class="field input">
                            <label for="event_date">Event Date:</label>
                            <input type="text" name="event_date" value="<?php echo $row['event_date']; ?>" />
                        </div>
                        <div class="field input" id="radio-control">
                            <label for="event_time">Event Time:</label>
                            <input type="text" name="event_time" value="<?php echo $row['event_time']; ?>" />
                        </div>
                        <div class="field input">
                            <label for="location">Location:</label>
                            <input type="text" name="location" value="<?php echo $row['location']; ?>" />
                        </div>
                        <div>
                            <label for="ticket_image">Ticket Image:</label>
                            <input type="file" id="ticket_image" name="ticket_image" accept="image/*"><br>
                        </div>
                        <div>
                            <label for="">Ticket's Price:</label>
                            <input type="text" id="ticket_price" name="ticket_price">
                        </div>
                        <?php // open php 5
                        }// close while loop
                        ?> <!-- close php 5 -->
                        <div class="field">
                            <input type="submit" name="update" value="Update" class="btn" />
                            <input type="submit" name="delete" value="Delete" class="btn">
                        </div>
                    </form>
                </div>
            </div>
            <?php // open php 6
        }
        if (isset($_POST['update']) && $_POST['update'] != "") {
            $ticket_id = $_POST['id'];
            $ticket_name = $_POST['ticket_name'];
            $event_date = $_POST['event_date'];
            $event_time = $_POST['event_time'];
            $location = $_POST['location'];
            $ticket_price = $_POST['ticket_price'];
            
            // Check if a file is uploaded
            if (isset($_FILES["ticket_image"]) && !empty($_FILES["ticket_image"]["tmp_name"])) {
                // Specify the target directory
                $target_dir = "C:/xampp/htdocs/EventOrganizerWebsite/event_images/";

                // Generate a unique filename to avoid overwriting existing files
                $target_file = $target_dir . uniqid() . '_' . basename($_FILES["ticket_image"]["name"]);

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["ticket_image"]["tmp_name"], $target_file)) {
                    // Update ticket details in the database with the image file path
                    $query = "UPDATE tickets SET ticket_name = '$ticket_name', event_date = '$event_date', event_time = '$event_time', location = '$location', ticket_image_path = '$target_file', ticket_price = '$ticket_price' WHERE ticket_id = $ticket_id";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        echo "Ticket updated successfully!";
                    } 
                    else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } 
                else {
                    echo "Error uploading file.";
                }
            }
            else{
                echo "No file uploaded";
            } 

            //close database connection
            mysqli_close($conn);
        }

        //delete features
        if (isset($_POST['delete']) && $_POST['delete'] != "") {
            $ticket_id = $_POST['id'];
            $ticket_name = $_POST['ticket_name'];

            //delete the ticket in the tickets table
            $query = "DELETE FROM tickets WHERE ticket_id='$ticket_id'";

            if(mysqli_query($conn, $query)){
            	echo "Successfully deleted the $ticket_name";
            }
            else{
            	echo "Error: " . $query . mysqli_error($conn);
            }
        }    
    ?> <!-- close php 6 -->
</body>
</html>
