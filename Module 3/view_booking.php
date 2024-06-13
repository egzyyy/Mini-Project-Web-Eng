<?php
include('../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Fetch bookings
$query = "SELECT b.B_bookingID, b.B_startTime, b.B_endTime, b.P_parkingSpaceID, v.V_vehicleID 
          FROM booking b 
          JOIN vehicle v ON b.V_vehicleID = v.V_vehicleID 
          ORDER BY b.B_startTime";
$result = mysqli_query($link, $query);

if (!$result) {
    die('Error executing query: ' . mysqli_error($link));
}

$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .action-button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .edit-button {
            background-color: #4CAF50;
            color: white;
        }
        .cancel-button {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Booking List</h1>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Parking Space ID</th>
            <th>Vehicle ID</th>
            <th>Actions</th>
        </tr>
        <?php if (empty($bookings)): ?>
            <tr>
                <td colspan="6">No bookings found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['B_bookingID']); ?></td>
                    <td><?php echo htmlspecialchars($booking['B_startTime']); ?></td>
                    <td><?php echo htmlspecialchars($booking['B_endTime']); ?></td>
                    <td><?php echo htmlspecialchars($booking['P_parkingSpaceID']); ?></td>
                    <td><?php echo htmlspecialchars($booking['V_vehicleID']); ?></td>
                    <td>
                        <button class="action-button edit-button" onclick="window.location.href='make_booking.php?id=<?php echo $booking['B_bookingID']; ?>&action=edit'">Edit</button>
                        <button class="action-button cancel-button" onclick="window.location.href='make_booking.php?id=<?php echo $booking['B_bookingID']; ?>&action=cancel'">Cancel</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>
