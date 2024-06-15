<?php
ob_start(); // Start output buffering
session_start();
include('../Layout/student_layout.php');

// Fetch booking details from QR code data
if (isset($_GET['qrText'])) {
    $qrText = $_GET['qrText'];
    $bookingData = json_decode($qrText, true);

    $bookingID = $bookingData['B_bookingID'];
    $vehicleID = $bookingData['V_vehicleID'];
    $startTime = $bookingData['B_startTime'];
    $parkingSpaceID = $bookingData['P_parkingSpaceID'];

    // Fetch additional booking details from database if needed
    $link = mysqli_connect("localhost", "root", "", "web_eng");
    if (!$link) {
        die('Error connecting to the server: ' . mysqli_connect_error());
    }

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
    die('Booking data not found');
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
        .qr-code img {
            width: 200px;
            height: 200px;
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
    <a href="view_parking.php?P_parkingSpaceID=<?php echo urlencode($booking['P_parkingSpaceID']); ?>&BookingID=<?php echo urlencode($bookingID); ?>&V_vehicleID=<?php echo urlencode($vehicleID); ?>&B_startTime=<?php echo urlencode($startTime); ?>&V_plateNum=<?php echo urlencode($booking['V_plateNum']); ?>&P_location=<?php echo urlencode($booking['P_location']); ?>&P_status=<?php echo urlencode($booking['P_status']); ?>&P_parkingType=<?php echo urlencode($booking['P_parkingType']); ?>" class="action-button">Proceed to Parking</a>
</div>
</body>
</html>
