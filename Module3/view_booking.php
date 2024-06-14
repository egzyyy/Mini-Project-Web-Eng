<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

$studentID = $_SESSION['STU_studentID'];

// Check if there is a delete action and handle accordingly
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $bookingID = $_GET['id'];

    // Check if the booking has an end_time
    $endTimeQuery = "SELECT B_endTime FROM booking WHERE B_bookingID = ?";
    $stmt = mysqli_prepare($link, $endTimeQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $bookingID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $booking = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($booking['B_endTime'] === null) {
            // Delete booking from active bookings
            $deleteQuery = "DELETE FROM booking WHERE B_bookingID = ?";
            $stmt = mysqli_prepare($link, $deleteQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'i', $bookingID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                header('Location: view_booking.php');
                exit();
            } else {
                die('Error preparing statement: ' . mysqli_error($link));
            }
        } else {
            // Booking has end_time, consider it as completed
            echo "<script>alert('Cannot delete booking with end time.');</script>";
        }
    } else {
        die('Error preparing statement: ' . mysqli_error($link));
    }
}

// Fetch active bookings (no end_time)
$query = "SELECT booking.*, vehicle.V_plateNum, parkingSpace.P_parkingSpaceID, parkingSpace.P_location, parkingSpace.P_status, parkingSpace.P_parkingType 
          FROM booking 
          JOIN vehicle ON booking.V_vehicleID = vehicle.V_vehicleID 
          JOIN parkingSpace ON booking.P_parkingSpaceID = parkingSpace.P_parkingSpaceID 
          WHERE vehicle.STU_studentID = ? AND booking.B_endTime IS NULL";
$stmt = mysqli_prepare($link, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $studentID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $activeBookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
} else {
    die('Error preparing statement: ' . mysqli_error($link));
}

// Fetch completed bookings (with end_time)
$query = "SELECT booking.*, vehicle.V_plateNum, parkingSpace.P_parkingSpaceID, parkingSpace.P_location, parkingSpace.P_status, parkingSpace.P_parkingType 
          FROM booking 
          JOIN vehicle ON booking.V_vehicleID = vehicle.V_vehicleID 
          JOIN parkingSpace ON booking.P_parkingSpaceID = parkingSpace.P_parkingSpaceID 
          WHERE vehicle.STU_studentID = ? AND booking.B_endTime IS NOT NULL";
$stmt = mysqli_prepare($link, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $studentID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $completedBookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
} else {
    die('Error preparing statement: ' . mysqli_error($link));
}

mysqli_close($link);
include('../Layout/student_layout.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <style>
        .content-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class='content-container'>
    <h1>My Bookings</h1>

    <h2>Active Bookings</h2>
    <?php if (!empty($activeBookings)): ?>
        <table>
            <tr>
                <th>Parking Space ID</th>
                <th>Location</th>
                <th>Status</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>Vehicle Plate Number</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($activeBookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['P_parkingSpaceID']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_location']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_status']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_parkingType']); ?></td>
                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($booking['B_startTime']))); ?></td>
                    <td><?php echo htmlspecialchars(date('H:i:s', strtotime($booking['B_startTime']))); ?></td>
                    <td><?php echo htmlspecialchars($booking['V_plateNum']); ?></td>
                    <td><img src="../../QRImage/booking<?php echo htmlspecialchars($booking['B_bookingID']); ?>.png" alt="QR Code" width="100"></td>
                    <td>
                        <a href="module3/edit_booking.php?id=<?php echo htmlspecialchars($booking['B_bookingID']); ?>">Edit</a>
                        <a href="module3/view_booking.php?action=delete&id=<?php echo htmlspecialchars($booking['B_bookingID']); ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No active bookings found.</p>
    <?php endif; ?>

    <h2>Completed Bookings</h2>
    <?php if (!empty($completedBookings)): ?>
        <table>
            <tr>
                <th>Parking Space ID</th>
                <th>Location</th>
                <th>Status</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Vehicle Plate Number</th>
                <th>QR Code</th>
            </tr>
            <?php foreach ($completedBookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['P_parkingSpaceID']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_location']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_status']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_parkingType']); ?></td>
                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($booking['B_startTime']))); ?></td>
                    <td><?php echo htmlspecialchars(date('H:i:s', strtotime($booking['B_startTime']))); ?></td>
                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($booking['B_endTime']))); ?></td>
                    <td><?php echo htmlspecialchars(date('H:i:s', strtotime($booking['B_endTime']))); ?></td>
                    <td><?php echo htmlspecialchars($booking['V_plateNum']); ?></td>
                    <td><img src="../../QRImage/booking<?php echo htmlspecialchars($booking['B_bookingID']); ?>.png" alt="QR Code" width="100"></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No completed bookings found.</p>
    <?php endif; ?>
</div>
</body>
</html>