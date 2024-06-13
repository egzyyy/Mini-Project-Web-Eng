<?php
require 'phpqrcode/qrlib.php';
$link = mysqli_connect("localhost", "username", "password", "database");

$bookingID = $_GET['id'];
$query = "SELECT * FROM booking WHERE B_bookingID = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $bookingID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$booking = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

mysqli_close($link);

// Generate QR code
$tempDir = "temp/";
$qrData = "Booking ID: " . $booking['B_bookingID'] . "\nStart Time: " . $booking['B_startTime'] . "\nEnd Time: " . $booking['B_endTime'] . "\nParking Space ID: " . $booking['P_parkingSpaceID'] . "\nVehicle ID: " . $booking['V_vehicleID'];
$qrFileName = $tempDir . 'booking_' . $bookingID . '.png';
QRcode::png($qrData, $qrFileName, QR_ECLEVEL_L, 5);

?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Code</title>
</head>
<body>
    <h1>QR Code for Booking</h1>
    <img src="<?php echo $qrFileName; ?>" alt="QR Code">
</body>
</html>
