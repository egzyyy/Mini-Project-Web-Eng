<?php
include('../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plateNum = $_POST['plateNum'];
    $endTime = $_POST['endTime'];

    // Check if the vehicle exists
    $vehicleQuery = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum = ?";
    $stmt = mysqli_prepare($link, $vehicleQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $plateNum);
        mysqli_stmt_execute($stmt);
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
                    // Insert booking information
                    $insertQuery = "INSERT INTO booking (B_startTime, B_endTime, P_parkingSpaceID, V_vehicleID) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($link, $insertQuery);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'ssii', $startTime, $endTime, $parkingSpaceID, $vehicleID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);

                        echo 'Booking created successfully';
                    } else {
                        die('Error preparing statement: ' . mysqli_error($link));
                    }
                }
            } else {
                die('Error preparing statement: ' . $link->error);
            }
        } else {
            die('Vehicle not found');
        }
    } else {
        die('Error preparing statement: ' . mysqli_error($link));
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parking</title>
</head>
<body>
    <div class='content-container'>
        <h2>Parking</h2>
        <form method="POST">
            <label for="plateNum">Vehicle Plate Number:</label>
            <input type="text" name="plateNum" id="plateNum" required>
            <br>
            <label for="endTime">End Time:</label>
            <input type="datetime-local" name="endTime" id="endTime" required>
            <br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>