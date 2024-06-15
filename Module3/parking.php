<?php
include('../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plateNum = $_POST['plateNum'];
    $endTime = $_POST['endTime'];
    $bookingID = isset($_POST['bookingID']) ? $_POST['bookingID'] : null;
    $parkingSpaceID = $_POST['P_parkingSpaceID'];

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

            if ($bookingID) {
                // If booking ID is provided, update the existing booking with the end time
                $updateBookingQuery = "UPDATE booking SET B_endTime = ?, B_duration = TIMESTAMPDIFF(MINUTE, B_startTime, ?) WHERE B_bookingID = ? AND B_endTime IS NULL";
                $stmt = mysqli_prepare($link, $updateBookingQuery);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ssi', $endTime, $endTime, $bookingID);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    echo 'Booking updated successfully';
                } else {
                    die('Error preparing statement: ' . mysqli_error($link));
                }
            } else {
                // If booking ID is not provided, create a new booking
                $startTime = date('Y-m-d H:i:s'); // Current time as start time

                // Check for existing booking for the same parking space and overlapping time
                $existingBookingQuery = "SELECT COUNT(*) AS count 
                                         FROM booking 
                                         WHERE P_parkingSpaceID = ? 
                                         AND (? < B_endTime AND ? > B_startTime)";
                $stmt = mysqli_prepare($link, $existingBookingQuery);
                if ($stmt) {
                    $parkingSpaceID = 1; // Set to the current parking space ID (replace this with your logic to get the correct ID)
                    mysqli_stmt_bind_param($stmt, 'iss', $parkingSpaceID, $startTime, $endTime);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($stmt);

                    if ($row['count'] > 0) {
                        die('The selected time slot is already booked for this parking space.');
                    } else {
                        // Insert booking information
                        $insertQuery = "INSERT INTO booking (B_startTime, B_endTime, P_parkingSpaceID, V_vehicleID, B_duration) VALUES (?, ?, ?, ?, TIMESTAMPDIFF(MINUTE, ?, ?))";
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
    <style>
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
    </style>
</head>
<body>
    <div class='content-container'>
        <h2>Parking</h2>
        <form method="POST">
            <label for="bookingID">Booking ID (if applicable):</label>
            <input type="text" name="bookingID" id="bookingID">
            <br>
            <input type="hidden" name="P_parkingSpaceID" value="<?php echo htmlspecialchars($_GET['P_parkingSpaceID']); ?>">
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
