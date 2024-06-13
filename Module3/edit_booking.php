<?php
session_start();
include('../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

$bookingID = isset($_GET['id']) ? $_GET['id'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicleID = $_POST['vehicleID'];
    $startTime = $_POST['startTime'];

    if ($action == 'edit') {
        // Fetch the current booking details
        $query = "SELECT P_parkingSpaceID FROM booking WHERE B_bookingID = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'i', $bookingID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $booking = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($booking) {
            $parkingSpaceID = $booking['P_parkingSpaceID'];

            // Check for booking clashes
            $query = "SELECT COUNT(*) AS clash_count FROM booking 
                      WHERE P_parkingSpaceID = ? 
                      AND B_startTime = ? 
                      AND B_bookingID != ?";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, 'ssi', $parkingSpaceID, $startTime, $bookingID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $clash = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($clash['clash_count'] > 0) {
                echo "Error: The selected time slot is already booked for this parking space.";
            } else {
                // Update the booking
                $query = "UPDATE booking SET B_startTime = ?, V_vehicleID = ? WHERE B_bookingID = ?";
                $stmt = mysqli_prepare($link, $query);
                mysqli_stmt_bind_param($stmt, 'ssi', $startTime, $vehicleID, $bookingID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                header("Location: view_bookings.php");
                exit();
            }
        }
    }
} elseif ($action == 'cancel') {
    $query = "DELETE FROM booking WHERE B_bookingID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $bookingID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("Location: view_bookings.php");
    exit();
}

$parkingSpaceID = '';
$vehicleID = '';
$startTime = '';

if ($action == 'edit' && $bookingID) {
    $query = "SELECT * FROM booking WHERE B_bookingID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $bookingID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $booking = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($booking) {
        $parkingSpaceID = $booking['P_parkingSpaceID'];
        $vehicleID = $booking['V_vehicleID'];
        $startTime = $booking['B_startTime'];
    }
}

$parkingSpace = null;
if ($parkingSpaceID) {
    $query = "SELECT P_location, P_status, P_parkingType FROM parkingSpace WHERE P_parkingSpaceID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $parkingSpaceID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $parkingSpace = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
</head>
<body>
    <div class='content-container'>
        <h1>Edit Booking</h1>
        <form method="POST">
            <label for="vehicleID">Vehicle Number Plate:</label>
            <input type="text" id="vehicleID" name="vehicleID" value="<?php echo htmlspecialchars($vehicleID); ?>" required>
            <br>
            <label for="startTime">Start Time:</label>
            <input type="datetime-local" id="startTime" name="startTime" value="<?php echo htmlspecialchars($startTime); ?>" required>
            <br>
            <button type="submit">Update Booking</button>
        </form>
    </div>
</body>
</html>
