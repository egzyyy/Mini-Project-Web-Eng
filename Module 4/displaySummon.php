<?php
session_start();

if (!isset($_SESSION['scanned_summon'])) {
    echo "No summon details available.";
    exit;
}

$summon = $_SESSION['scanned_summon'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanned Summon Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            max-width: 600px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Scanned Summon Details</h2>
        <p><strong>Plate Number:</strong> <?php echo htmlspecialchars($summon['plate_number']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($summon['date']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($summon['status']); ?></p>
        <p><strong>Violation Type:</strong> <?php echo htmlspecialchars($summon['violation_type']); ?></p>
        <p><strong>Demerit Points:</strong> <?php echo htmlspecialchars($summon['demerit_points']); ?></p>
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>
</body>
</html>
