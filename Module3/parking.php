<?php
// Establish database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

// Check if connection is successful
if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

$bookingID = isset($_POST['bookingID']) ? $_POST['bookingID'] : '';
$plateNum = isset($_POST['plateNum']) ? $_POST['plateNum'] : '';
$endTime = isset($_POST['endTime']) ? $_POST['endTime'] : '';
$parkingSpaceID = isset($_POST['P_parkingSpaceID']) ? $_POST['P_parkingSpaceID'] : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($bookingID)) {
        // Update existing booking
        $query = "UPDATE booking SET B_endTime = ?, B_duration = TIMESTAMPDIFF(MINUTE, B_startTime, ?) WHERE B_bookingID = ? AND B_endTime IS NULL";
        $stmt = mysqli_prepare($link, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssi', $endTime, $endTime, $bookingID);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                echo 'Booking updated successfully';
            } else {
                die('Error updating booking: ' . mysqli_error($link));
            }
        } else {
            die('Error preparing update statement: ' . mysqli_error($link));
        }
    } else {
        // Create new booking
        // Check if the vehicle exists
        $vehicleQuery = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum = ?";
        $stmt = mysqli_prepare($link, $vehicleQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $plateNum);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $vehicle = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);

                if ($vehicle) {
                    $vehicleID = $vehicle['V_vehicleID'];
                    $startTime = date('Y-m-d H:i:s'); // Current time as start time

                    // Check for existing booking for the same parking space and overlapping time
                    $existingBookingQuery = "SELECT COUNT(*) AS count 
                                             FROM booking 
                                             WHERE P_parkingSpaceID = ? 
                                             AND (? < B_endTime AND ? > B_startTime)";
                    $stmt = mysqli_prepare($link, $existingBookingQuery);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'iss', $parkingSpaceID, $startTime, $endTime);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        mysqli_stmt_close($stmt);

                        if ($row['count'] > 0) {
                            die('The selected time slot is already booked for this parking space.');
                        } else {
                            // Insert new booking information
                            $insertQuery = "INSERT INTO booking (B_startTime, B_endTime, P_parkingSpaceID, V_vehicleID, B_duration) VALUES (?, ?, ?, ?, TIMESTAMPDIFF(MINUTE, ?, ?))";
                            $stmt = mysqli_prepare($link, $insertQuery);
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, 'ssiiis', $startTime, $endTime, $parkingSpaceID, $vehicleID, $startTime, $endTime);
                                if (mysqli_stmt_execute($stmt)) {
                                    mysqli_stmt_close($stmt);
                                    echo 'Booking created successfully';
                                } else {
                                    die('Error creating booking: ' . mysqli_error($link));
                                }
                            } else {
                                die('Error preparing insert statement: ' . mysqli_error($link));
                            }
                        }
                    } else {
                        die('Error preparing check booking statement: ' . mysqli_error($link));
                    }
                } else {
                    die('Vehicle not found');
                }
            } else {
                die('Error executing vehicle query: ' . mysqli_error($link));
            }
        } else {
            die('Error preparing vehicle query: ' . mysqli_error($link));
        }
    }
}

// Fetch booking details if BookingID is provided
if (!empty($bookingID)) {
    $fetchBookingQuery = "SELECT * FROM booking 
                          INNER JOIN vehicle ON booking.V_vehicleID = vehicle.V_vehicleID
                          INNER JOIN parking_space ON booking.P_parkingSpaceID = parking_space.P_parkingSpaceID
                          WHERE booking.B_bookingID = ?";
    $stmt = mysqli_prepare($link, $fetchBookingQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $bookingID);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $booking = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        } else {
            die('Error fetching booking details: ' . mysqli_error($link));
        }
    } else {
        die('Error preparing fetch statement: ' . mysqli_error($link));
    }
}

// Close database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .content-container h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label, input {
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #555;
        }
        .parking-info {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .parking-info div {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .parking-info div label {
            font-weight: bold;
            margin-right: 10px;
            width: 120px;
        }
        .parking-info div span {
            flex: 1;
        }
        .action-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .action-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .action-button:hover {
            background-color: #555;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<div class="content-container">
    <h2>Parking</h2>
    <?php if (!empty($bookingID) && isset($booking)): ?>
        <!-- Display existing booking information if BookingID is provided -->
        <div class="parking-info">
            <div>
                <label>Booking ID:</label>
                <span><?php echo htmlspecialchars($booking['B_bookingID']); ?></span>
            </div>
            <div>
                <label>Vehicle Plate Number:</label>
                <span><?php echo htmlspecialchars($booking['V_plateNum']); ?></span>
            </div>
            <div>
                <label>Start Time:</label>
                <span><?php echo htmlspecialchars($booking['B_startTime']); ?></span>
            </div>
            <div>
                <label>End Time:</label>
                <span><?php echo htmlspecialchars($booking['B_endTime']); ?></span>
            </div>
            <div>
                <label>Parking Space ID:</label>
                <span><?php echo htmlspecialchars($booking['P_parkingSpaceID']); ?></span>
            </div>
        </div>
    <?php else: ?>
        <!-- Display booking form if no BookingID or no valid booking found -->
        <form method="POST">
            <input type="hidden" name="bookingID" value="<?php echo htmlspecialchars($bookingID); ?>">
            <input type="hidden" name="P_parkingSpaceID" value="<?php echo htmlspecialchars($_GET['P_parkingSpaceID']); ?>">
            <?php if (empty($bookingID)): ?>
                <label for="plateNum">Vehicle Plate Number:</label>
                <input type="text" name="plateNum" id="plateNum" required>
            <?php endif; ?>
            <label for="endTime">End Time:</label>
            <input type="datetime-local" name="endTime" id="endTime" required>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($bookingID)): ?>
        <!-- Back button if BookingID is provided -->
        <a href="list_bookings.php" class="back-button">Back to Bookings List</a>
    <?php endif; ?>
</div>
</body>
</html>
