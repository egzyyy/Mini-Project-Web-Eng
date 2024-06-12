<?php
session_start();

if (!isset($_SESSION['summon'])) {
    echo "No summon details available.";
    exit;
}

$summon = $_SESSION['summon'];
$qrData = json_encode($summon);
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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Summon Details</h2>
        <p><strong>Plate Number:</strong> <?php echo htmlspecialchars($summon['plate_number']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($summon['date']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($summon['status']); ?></p>
        <p><strong>Violation Type:</strong> <?php echo htmlspecialchars($summon['violation_type']); ?></p>
        <p><strong>Demerit Points:</strong> <?php echo htmlspecialchars($summon['demerit_points']); ?></p>
        <h3>QR Code</h3>
        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($qrData); ?>&amp;size=200x200" alt="Summon QR Code">
        <div class="button-container">
            <form action="index.php" method="get">
                <button type="submit">Back to Home</button>
            </form>
        </div>
    </div>
</body>
</html>
