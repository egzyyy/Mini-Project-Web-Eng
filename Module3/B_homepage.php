<?php
include('../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Fetch parking spaces
$query = "SELECT * FROM parkingSpace ORDER BY P_location, P_parkingSpaceID";
$result = mysqli_query($link, $query);
$parkingSpaces = [];
while ($row = mysqli_fetch_assoc($result)) {
    $parkingSpaces[$row['P_location']][] = $row;
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Parking Spaces</title>
    <style>
        
        .location {
            margin-bottom: 30px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;;
            gap: 15px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
        }
        .available {
            background-color: green;
            color: white;
        }
        .closed {
            background-color: red;
            color: white;
        }
        .button-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <div class="button-container">
            <button onclick="window.location.href='view_booking.php'">View Booking List</button>
        </div>
        <h1>Parking Spaces</h1>
        <?php foreach ($parkingSpaces as $location => $spaces): ?>
            <div class="location">
                <h2>Location: <?php echo htmlspecialchars($location); ?></h2>
                <div class="grid-container">
                    <?php foreach ($spaces as $space): ?>
                        <div class="card <?php echo strtolower($space['P_status']); ?>" onclick="window.location.href='make_booking.php?id=<?php echo $space['P_parkingSpaceID']; ?>'">
                            <p>ID: <?php echo htmlspecialchars($space['P_parkingSpaceID']); ?></p>
                            <p>Status: <?php echo htmlspecialchars($space['P_status']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>