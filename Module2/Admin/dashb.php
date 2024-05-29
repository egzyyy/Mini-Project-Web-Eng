<?php
include('../../Layout/admin_layout.php');
$link = new mysqli('localhost', 'root', '', 'web_eng');

if ($link->connect_error) {
    die('Error connecting to the server: ' . $link->connect_error);
}

// Fetch total parking spaces
$totalSpacesResult = $link->query("SELECT COUNT(*) AS total_spaces FROM parkingSpace");
$totalSpaces = $totalSpacesResult->fetch_assoc()['total_spaces'];

// Fetch occupied spaces
$occupiedSpacesResult = $link->query("SELECT COUNT(*) AS occupied_spaces FROM parkingSpace WHERE is_available = 0");
$occupiedSpaces = $occupiedSpacesResult->fetch_assoc()['occupied_spaces'];

// Calculate available spaces
$availableSpaces = $totalSpaces - $occupiedSpaces;

// Fetch temporarily closed spaces
$closedSpacesResult = $link->query("SELECT COUNT(*) AS closed_spaces FROM parkingSpace WHERE is_closed = 1");
$closedSpaces = $closedSpacesResult->fetch_assoc()['closed_spaces'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 270px; /* Adjust this value based on the width of your sidebar */
            margin-top: 20px; /* Adjust this value based on the height of your header */
        }
        .dashboard-overview {
            display: flex;
            flex-direction: row;
            /* justify-content: space-between; */
            margin-top: 20px;
        }
        .card {
            flex: 1;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .dashboard-overview .card:last-child {
            margin-right: 0;
        }
        .card h1 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }
        .card p {
            margin: 0;
            font-size: 18px;
            color: #555;    
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Admin Dashboard</h1>
        <div class="dashboard-overview">
            <div class="card">
                <h2>Total Parking Spaces</h2>
                <p><?= $totalSpaces ?></p>
            </div>
            <div class="card">
                <h2>Occupied Spaces</h2>
                <p><?= $occupiedSpaces ?></p>
            </div>
            <div class="card">
                <h2>Available Spaces</h2>
                <p><?= $availableSpaces ?></p>
            </div>
            <div class="card">
                <h2>Temporarily Closed Spaces</h2>
                <p><?= $closedSpaces ?></p>
            </div>
        </div>
        <!-- You can add more sections here, such as charts or recent activity -->
    </div>
</body>
</html>

<?php
$link->close();
?>
