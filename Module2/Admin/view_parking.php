<?php
include('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

mysqli_select_db($link, "web_eng");

// Fetch parking space information based on the ID in the query string
$parkingSpaceID = isset($_GET['P_parkingSpaceID']) ? mysqli_real_escape_string($link, $_GET['P_parkingSpaceID']) : '';

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
    <title>View Parking Space</title>
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .content-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .parking-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .parking-info div {
            margin: 10px 0;
        }
        .parking-info div label {
            font-weight: bold;
            margin-right: 10px;
        }
        .qr-code {
            margin-top: 20px;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #555;
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
        </div>
        <a href="manage_parking.php" class="back-button">Back to Manage Parking</a>
    <?php else: ?>
        <p>Parking space not found. Please check the ID and try again.</p>
    <?php endif; ?>
</div>
</body>
</html>
