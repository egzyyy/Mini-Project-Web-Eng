<?php
include('../Layout/student_layout.php');
// Include the database connection file
include ('../db.php');

// Fetch existing bookings to populate the dropdown
$bookings_sql = "SELECT * FROM booking";
$bookings_result = $link->query($bookings_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $booking_id = mysqli_real_escape_string($link, $_POST['booking_id']);
    $car = mysqli_real_escape_string($link, $_POST['car']);
    $date = mysqli_real_escape_string($link, $_POST['date']);
    $time = mysqli_real_escape_string($link, $_POST['time']);

    // Check for clashing bookings
    $check_sql = "SELECT * FROM booking WHERE B_startTime <= '$date $time' AND B_endTime >= '$date $time' AND P_parkingSpaceID = '$car' AND B_bookingID != '$booking_id'";
    $result = $link->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<p>Booking clash detected. Please choose another time or parking space.</p>";
    } else {
        // Update booking in the database
        $update_sql = "UPDATE booking SET B_startTime = '$date $time', B_endTime = DATE_ADD('$date $time', INTERVAL 1 HOUR), P_parkingSpaceID = '$car' WHERE B_bookingID = '$booking_id'";
        if ($link->query($update_sql) === TRUE) {
            echo "<h2>Booking Updated Successfully</h2>";
            echo "<p>Booking ID: $booking_id</p>";
            echo "<p>Car: $car</p>";
            echo "<p>Date: $date</p>";
            echo "<p>Time: $time</p>";
        } else {
            echo "Error: " . $update_sql . "<br>" . $link->error;
        }
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
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
        form {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin: 10px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select,
        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .form-group button {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #555;
        }
        .message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Edit Booking</h2>
        <form method="post" action="edit_booking.php">
            <div class="form-group">
                <label for="booking_id">Booking ID:</label>
                <select name="booking_id" id="booking_id" required>
                    <?php
                    while ($booking_row = $bookings_result->fetch_assoc()) {
                        echo "<option value='" . $booking_row['B_bookingID'] . "'>" . $booking_row['B_bookingID'] . " - " . $booking_row['B_startTime'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="car">Car:</label>
                <select name="car" id="car" required>
                    <?php
                    $car_sql = "SELECT * FROM vehicle";
                    $car_result = $link->query($car_sql);
                    while ($car_row = $car_result->fetch_assoc()) {
                        echo "<option value='" . $car_row['V_vehicleID'] . "'>" . $car_row['V_plateNum'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Booking</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
}
?>
