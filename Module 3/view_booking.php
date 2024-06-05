<?php
// Include the database connection file
include ('../db.php');

// Retrieve bookings from the database
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);
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
        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Bookings</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
        $conn->close();
        ?>
    </div>
</body>
</html>
