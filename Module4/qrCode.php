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

// Generate the QR code with a dynamic filename
$filename = "QRCodeS/qrcode_" . $plate_number . ".png";

// Check if the directory exists, if not create it
if (!is_dir('QRCodeS')) {
    mkdir('QRCodeS', 0755, true); // Create the directory with proper permissions
}

// Generate the QR code and save to file
QRcode::png($json_data, $filename);

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
            margin: 0;
        }

        .qr-container {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 80%;
            max-width: 600px;
            margin: 20px;
        }

        .qr-container h2 {
            margin-bottom: 20px;
        }

        .qr-container img {
            margin-top: 20px;
            max-width: 100%;
            height: auto;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #800000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #575757;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h2>Summon QR Code</h2>
        <img src="<?php echo $filename; ?>" alt="Summon QR Code">
        <a href="applySummon.php" class="back-button">Back to Home</a>
    </div>
</body>
</html>
