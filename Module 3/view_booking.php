<?php
include('../Layout/student_layout.php');



$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if form is submitted and the apply-summon button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $B_bookingID = $_POST['B_bookingID'];
    $B_endTime = $_POST['B_endTime'];
    $P_parkingspaceID = $_POST['P_parkingspaceID'];
    $B_startTime = $_POST['B_startTime'];

    // Get the vehicle ID based on the plate number
    $sql = "SELECT B_bookingID FROM booking";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vehicle_id = $row['V_vehicleID'];

        // Insert the summon
        $sql = "INSERT INTO booking (B_startTime, B_endTime, P_parkingspaceID, B_bookingID)
                VALUES ('$B_startTime', '$B_endTime', '$P_parkingspaceID', '$B_bookingID')";

        if ($link->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>New summon added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $link->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>No vehicle found with that plate number.</div>";
    }
}

// Fetch existing bookings
$booking_sql = "SELECT * FROM booking";
$booking_result = $link->query($booking_sql);

// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .booking {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .booking p {
            line-height: 1.6;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Your Bookings</h2>
        <?php
        if ($booking_result->num_rows > 0) {
            while ($row = $booking_result->fetch_assoc()) {
                echo "<div class='booking'>";
                echo "<p><strong>Booking ID:</strong> " . $row['B_bookingID'] . "</p>";
                echo "<p><strong>Start Time:</strong> " . $row['B_startTime'] . "</p>";
                echo "<p><strong>End Time:</strong> " . $row['B_endTime'] . "</p>";
                echo "<p><strong>Parking Space ID:</strong> " . $row['P_parkingSpaceID'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No bookings found.</p>";
        }
        ?>
    </div>
</body>
</html>
