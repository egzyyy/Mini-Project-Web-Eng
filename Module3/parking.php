<?php
session_start();
include('../Layout/student_layout.php');

// Check if student is logged in
if (!isset($_SESSION['STU_studentID'])) {
    die('Student not logged in');
}

// Validate the token
if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['enter_end_time_token']) {
    die('Invalid or missing token');
}

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if the student has made a booking
$bookingID = isset($_SESSION['bookingID']) ? $_SESSION['bookingID'] : null;
$bookingExists = false;


if ($bookingID) {
    // Fetch booking details
    $query = "SELECT * FROM booking WHERE B_bookingID = ?";
    $stmt = mysqli_prepare($link, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $bookingID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $booking = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($booking) {
            $bookingExists = true;
        }
    } else {
        die('Error preparing statement: ' . mysqli_error($link));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $endTime = $_POST['endTime'];

    if ($bookingExists) {
        // Student who made a booking, update end time and duration
        $bookingID = $_SESSION['bookingID'];

        // Validate and update booking with end time and duration
        $updateQuery = "UPDATE booking SET B_endTime = ? WHERE B_bookingID = ?";
        $stmt = mysqli_prepare($link, $updateQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'si', $endTime, $bookingID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "End time successfully updated!";
            // Clear booking session
            unset($_SESSION['bookingID']);
        } else {
            die('Error preparing statement: ' . mysqli_error($link));
        }
    } else {
        // Student who scanned QR code, insert new booking
        $plateNum = $_POST['plateNum'];
        $startTime = $_POST['startTime'];
        $parkingSpaceID = $_POST['parkingSpaceID'];
        $studentID = $_SESSION['STU_studentID'];

        // Fetch vehicle ID based on plate number
        $vehicleQuery = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum = ? AND STU_studentID = ?";
        $stmt = mysqli_prepare($link, $vehicleQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'si', $plateNum, $studentID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $vehicle = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($vehicle) {
                $vehicleID = $vehicle['V_vehicleID'];

                // Check for booking clashes
                $endTime = $_POST['endTime'];
                $clashError = '';

                $startTimeObj = new DateTime($startTime);
                $endTimeObj = new DateTime($endTime);
                $duration = $startTimeObj->diff($endTimeObj)->format('%h') + ($startTimeObj->diff($endTimeObj)->format('%i') / 60);

                // Check if the selected parking space is available for the given time slot
                $query = "SELECT COUNT(*) AS count FROM booking WHERE P_parkingSpaceID = ? AND ((B_startTime <= ? AND B_endTime > ?) OR (B_startTime < ? AND B_endTime >= ?))";
                $stmt = mysqli_prepare($link, $query);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'issss', $parkingSpaceID, $startTime, $startTime, $endTime, $endTime);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($stmt);

                    if ($row['count'] > 0) {
                        $clashError = "The selected time slot is already booked for this parking space. Please choose a different time.";
                    }
                } else {
                    die('Error preparing statement: ' . mysqli_error($link));
                }

                if (empty($clashError)) {
                    // Proceed with booking insertion
                    $insertQuery = "INSERT INTO booking (B_startTime, B_endTime, B_duration, P_parkingSpaceID, V_vehicleID) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($link, $insertQuery);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'ssiii', $startTime, $endTime, $duration, $parkingSpaceID, $vehicleID);
                        mysqli_stmt_execute($stmt);
                        $bookingID = mysqli_insert_id($link);
                        mysqli_stmt_close($stmt);

                        echo "Booking successfully made!";
                    } else {
                        die('Error preparing statement: ' . mysqli_error($link));
                    }
                } else {
                    echo $clashError;
                }
            } else {
                echo "Invalid vehicle selected.";
            }
        } else {
            die('Error preparing statement: ' . mysqli_error($link));
        }
    }
}

// Fetch available vehicles for the student
$vehicles = [];
$query = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE STU_studentID = ?";
$stmt = mysqli_prepare($link, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['STU_studentID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicles[] = $row;
    }
    mysqli_stmt_close($stmt);
} else {
    die('Error preparing statement: ' . mysqli_error($link));
}

// Fetch available parking spaces
$parkingSpaces = [];
$query = "SELECT P_parkingSpaceID, P_location FROM parkingSpace WHERE P_status = 'Available'";
$stmt = mysqli_prepare($link, $query);
if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $parkingSpaces[] = $row;
    }
    mysqli_stmt_close($stmt);
} else {
    die('Error preparing statement: ' . mysqli_error($link));
}

mysqli_close($link);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Enter End Time</title>
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h1>Enter End Time</h1>
        <form method="POST">
            <input type="hidden" name="parkingSpaceID" value="<?php echo htmlspecialchars($parkingSpaceID); ?>">
            <label for="endTime">End Time:</label>
            <input type="datetime-local" id="endTime" name="endTime" required>
            <br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
