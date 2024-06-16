<?php
session_start();
include('../Layout/student_layout.php');

// Fetch booking details using booking ID from the QR code
if (isset($_GET['bookingID'])) {
    $bookingID = $_GET['bookingID'];

    // Connect to the database
    $link = mysqli_connect("localhost", "root", "", "web_eng");
    if (!$link) {
        die('Error connecting to the server: ' . mysqli_connect_error());
    }

    // Fetch booking details from the database
    $sql = "SELECT b.B_startTime, b.P_parkingSpaceID, p.P_location, p.P_status, p.P_parkingType, v.V_plateNum
            FROM booking b
            JOIN parkingSpace p ON b.P_parkingSpaceID = p.P_parkingSpaceID
            JOIN vehicle v ON b.V_vehicleID = v.V_vehicleID
            WHERE b.B_bookingID = ?";
            
    $stmt = $link->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $bookingID);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();
    } else {
        die('Error preparing statement: ' . $link->error);
    }

    mysqli_close($link);
} else {
    die('Booking ID not found');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
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
    <h1>Booking Confirmation</h1>
    <p>Booking ID: <?php echo htmlspecialchars($bookingID); ?></p>
    <p>Vehicle Number Plate: <?php echo htmlspecialchars($booking['V_plateNum']); ?></p>
    <p>Parking Space: <?php echo htmlspecialchars($booking['P_parkingSpaceID']); ?></p>
    <p>Location: <?php echo htmlspecialchars($booking['P_location']); ?></p>
    <p>Status: <?php echo htmlspecialchars($booking['P_status']); ?></p>
    <p>Type: <?php echo htmlspecialchars($booking['P_parkingType']); ?></p>
    <p>Start Time: <?php echo htmlspecialchars($booking['B_startTime']); ?></p>
    
    <form action="module2/Admin/view_parking.php" method="post">
        <input type="hidden" name="P_parkingSpaceID" value="<?php echo htmlspecialchars($booking['P_parkingSpaceID']); ?>">
        <input type="hidden" name="BookingID" value="<?php echo htmlspecialchars($bookingID); ?>">
        <input type="hidden" name="B_startTime" value="<?php echo htmlspecialchars($booking['B_startTime']); ?>">
        <input type="hidden" name="V_plateNum" value="<?php echo htmlspecialchars($booking['V_plateNum']); ?>">
        <input type="hidden" name="P_location" value="<?php echo htmlspecialchars($booking['P_location']); ?>">
        <input type="hidden" name="P_status" value="<?php echo htmlspecialchars($booking['P_status']); ?>">
        <input type="hidden" name="P_parkingType" value="<?php echo htmlspecialchars($booking['P_parkingType']); ?>">
        <button type="submit" class="action-button">Proceed to Parking</button>
    </form>
</div>
</body>
</html>