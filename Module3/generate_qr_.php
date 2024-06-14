<?php
session_start();
include('../phpqrcode/qrlib.php');

if (!isset($_SESSION['summon'])) {
    echo "No summon data found.";
    exit();
}

$booking = $_SESSION['summon'];
$plate_number = $booking['plate_number'];
$date = $booking['date'];
$status = $booking['status'];
$violation_type = $summon['violation_type'];
$demerit_points = $summon['demerit_points'];


// Create an associative array with the summon data
$data = [
    'plate_number' => $plate_number,
    'date' => $date,
    'status' => $status,
    'violation_type' => $violation_type,
    'demerit_points' => $demerit_points
];

// Convert the array to JSON
$json_data = json_encode($data);

if ($json_data === false) {
    echo "Error encoding summon data to JSON.";
    exit();
}

$fileName = "QRCodeS/qrcode_" . $bookingID . ".png";

// Check if the directory exists, if not create it
if (!is_dir('QRCodeS')) {
    mkdir('QRCodeS', 0755, true); // Create the directory with proper permissions
}

// Generate the QR code and save to file
QRcode::png($json_data, $filename);

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
