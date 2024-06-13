<?php
session_start();
include('../phpqrcode/qrlib.php');

if (!isset($_SESSION['summon'])) {
    echo "No summon data found.";
    exit();
}

$summon = $_SESSION['summon'];
$plate_number = $summon['plate_number'];
$date = $summon['date'];
$status = $summon['status'];
$violation_type = $summon['violation_type'];
$demerit_points = $summon['demerit_points'];

$data = "Plate Number: $plate_number\nDate: $date\nStatus: $status\nViolation Type: $violation_type\nDemerit Points: $demerit_points";

// Generate the QR code
QRcode::png($data, 'qrcode.png');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .qr-container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }

        .qr-container h2 {
            margin-bottom: 20px;
        }

        .qr-container img {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h2>Summon QR Code</h2>
        <p>Scan the QR code below to get the summon details.</p>
        <img src="qrcode.png" alt="Summon QR Code">
    </div>
</body>
</html>
