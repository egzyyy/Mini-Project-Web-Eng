<?php
include('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

mysqli_select_db($link, "web_eng");

// Fetch parking space information based on the ID in the query string
$parkingSpaceID = isset($_GET['P_parkingSpaceID']) ? mysqli_real_escape_string($link, $_GET['P_parkingSpaceID']) : '';

if (isset($_POST['BookingID'], $_POST['P_parkingSpaceID'], $_POST['B_startTime'], $_POST['V_plateNum'], $_POST['P_location'], $_POST['P_status'], $_POST['P_parkingType'])) {
    // Fetch parameters from $_POS
    $bookingID = $_POST['BookingID'];
    $parkingSpaceID = $_POST['P_parkingSpaceID'];
    $startTime = $_POST['B_startTime'];
    $vehiclePlateNum = $_POST['V_plateNum'];
    $parkingLocation = $_POST['P_location'];
    $parkingStatus = $_POST['P_status'];
    $parkingType = $_POST['P_parkingType'];

    // Example of using the fetched parameters
    echo "<h1>View Parking Page</h1>";
    echo "<p>Booking ID: " . htmlspecialchars($bookingID) . "</p>";
    echo "<p>Parking Space ID: " . htmlspecialchars($parkingSpaceID) . "</p>";
    echo "<p>Start Time: " . htmlspecialchars($startTime) . "</p>";
    echo "<p>Vehicle Plate Number: " . htmlspecialchars($vehiclePlateNum) . "</p>";
    echo "<p>Parking Location: " . htmlspecialchars($parkingLocation) . "</p>";
    echo "<p>Parking Status: " . htmlspecialchars($parkingStatus) . "</p>";
    echo "<p>Parking Type: " . htmlspecialchars($parkingType) . "</p>";
} else {
    echo "Required parameters are missing.";
}

$parkingSpace = null;
if ($parkingSpaceID) {
    $query = "SELECT * FROM parkingSpace WHERE P_parkingSpaceID = '$parkingSpaceID'";
    $result = mysqli_query($link, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $parkingSpace = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Parking Space</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .content-container h2 {
            text-align: center;
            color: #333;
        }
        .parking-info {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .parking-info div {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .parking-info div label {
            font-weight: bold;
            margin-right: 10px;
            width: 120px;
        }
        .parking-info div span {
            flex: 1;
        }
        .qr-code {
            margin-top: 20px;
            text-align: center;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .action-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .action-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .action-button:hover {
            background-color: #555;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<div class="content-container">
    <h2>Parking Space Information</h2>
    <?php if ($parkingSpace): ?>
        <div class="parking-info">
            <div>
                <label>ID:</label>
                <span><?php echo htmlspecialchars($parkingSpace['P_parkingSpaceID']); ?></span>
            </div>
            <div>
                <label>Location:</label>
                <span><?php echo htmlspecialchars($parkingSpace['P_location']); ?></span>
            </div>
            <div>
                <label>Status:</label>
                <span><?php echo htmlspecialchars($parkingSpace['P_status']); ?></span>
            </div>
            <div>
                <label>Type:</label>
                <span><?php echo htmlspecialchars($parkingSpace['P_parkingType']); ?></span>
            </div>
            <div class="qr-code">
                <label>QR Code:</label>
                <img src="../../QRImage/parking<?php echo htmlspecialchars($parkingSpace['P_parkingSpaceID']); ?>.png" alt="QR Code">
            </div>
            <div class="action-buttons">
            <a href="../../module3/parking.php?P_parkingSpaceID=<?php echo urlencode($parkingSpaceID); ?>&BookingID=<?php echo urlencode($bookingID); ?>&V_vehicleID=<?php echo urlencode($vehicleID); ?>&B_startTime=<?php echo urlencode($startTime); ?>&V_plateNum=<?php echo urlencode($plateNum); ?>&P_location=<?php echo urlencode($location); ?>&P_status=<?php echo urlencode($status); ?>&P_parkingType=<?php echo urlencode($type); ?>" class="action-button">Enter End Time</a>
                <!-- Add more action buttons here if needed -->
                <!-- Add more action buttons here if needed -->
            </div>
        </div>
    <form id="endTimeForm" action="../../module3/parking.php" method="GET">
    <input type="hidden" name="P_parkingSpaceID" value="<?php echo htmlspecialchars($parkingSpace['P_parkingSpaceID']); ?>">
    <input type="hidden" name="BookingID" value="<?php echo urlencode($bookingID); ?>">
    <input type="hidden" name="V_vehicleID" value="<?php echo urlencode($vehicleID); ?>">
    <input type="hidden" name="B_startTime" value="<?php echo urlencode($startTime); ?>">
    <input type="hidden" name="V_plateNum" value="<?php echo urlencode($plateNum); ?>">
    <input type="hidden" name="P_location" value="<?php echo urlencode($location); ?>">
    <input type="hidden" name="P_status" value="<?php echo urlencode($status); ?>">
    <input type="hidden" name="P_parkingType" value="<?php echo urlencode($type); ?>">
    <?php else: ?>
        <p style="text-align: center;">Parking space not found. Please check the ID and try again.</p>
    <?php endif; ?>
</div>
</body>
</html>
