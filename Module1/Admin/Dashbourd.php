<?php
session_start();
require('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Include database connection file
mysqli_select_db($link, "web_eng");

// Query to count the total number of users registered
$query_total_users = "SELECT COUNT(*) AS total_users FROM student";
$result_total_users = mysqli_query($link, $query_total_users);

if ($result_total_users) {
    $row_total_users = mysqli_fetch_assoc($result_total_users);
    $total_users = $row_total_users['total_users'];
} else {
    $total_users = 0;
}

// Query to get the counts for each parking location
$query_parking_counts = "SELECT P_location, COUNT(*) AS parking_count FROM parkingSpace GROUP BY P_location";
$result_parking_counts = mysqli_query($link, $query_parking_counts);

$locations = [];
$locationCounts = [];
$max_location = '';
$max_count = 0;

if ($result_parking_counts) {
    while ($row_parking_counts = mysqli_fetch_assoc($result_parking_counts)) {
        $locations[] = $row_parking_counts['P_location'];
        $locationCounts[] = $row_parking_counts['parking_count'];
        if ($row_parking_counts['parking_count'] > $max_count) {
            $max_count = $row_parking_counts['parking_count'];
            $max_location = $row_parking_counts['P_location'];
        }
    }
} else {
    $locations = ['Location1', 'Location2', 'Location3'];
    $locationCounts = [10, 15, 8];
}

// Fetch booking counts based on selected location
$selected_location = isset($_POST['location']) ? $_POST['location'] : '';
$booking_counts = [];

if ($selected_location) {
    $query_bookings = "SELECT booking.P_parkingSpaceID, COUNT(booking.B_bookingID) AS booking_count
                       FROM booking
                       INNER JOIN parkingSpace ON booking.P_parkingSpaceID = parkingSpace.P_parkingSpaceID
                       WHERE parkingSpace.P_location = ?
                       GROUP BY booking.P_parkingSpaceID";
    $stmt = $link->prepare($query_bookings);
    if ($stmt) {
        $stmt->bind_param("s", $selected_location);
        $stmt->execute();
        $result_bookings = $stmt->get_result();
        while ($row = $result_bookings->fetch_assoc()) {
            $booking_counts[] = [
                'P_parkingSpaceID' => $row['P_parkingSpaceID'],
                'booking_count' => $row['booking_count']
            ];
        }
        $stmt->close();
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 10px;
        }

        .dashboard-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-title {
            font-size: 24px;
            font-weight: bold;
        }

        .dashboard-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 10px 20px;
            background-color: #2a45f1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: #1e326b;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .dashboard-card {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-content {
            font-size: 14px;
        }

        .announcement-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 10px;
        }

        .announcement-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            padding-bottom: 60px;
        }

        .announcement-text {
            font-size: 16px;
            color: #333;
        }

        .display-date {
            text-align: center;
            margin-bottom: 10px;
            font-size: 1.6rem;
            font-weight: 600;
        }

        #vehicleChartContainer {
            width: 80%;
            margin: auto;
            height: calc(100vh - 40px); /* Subtract header height */
        }

        canvas {
            height: 100%;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container select, .form-container button {
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .chart-container {
            margin-top: 20px;
            width: 80%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="dashboard-title">Admin Dashboard</div>
            <!-- <div class="dashboard-actions">
                <button class="action-btn">Action 1</button>
                <button class="action-btn">Action 2</button>
            </div> -->
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-title">Total Registered Users</div>
                <div class="card-content"><?php echo $total_users; ?></div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Location with Most Parking Spaces</div>
                <div class="card-content"><?php echo $max_location . " (" . $max_count . " spaces)"; ?></div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Parking Spaces per Location</div>
                <div class="card-content">
                    <canvas id="parkingChart"></canvas>
                </div>
            </div>
        </div>
        <div class="form-container">
            <h2>View Booking Counts by Parking Space</h2>
            <form method="POST">
                <label for="location">Select Location:</label>
                <select name="location" id="location" required>
                    <?php foreach ($locations as $location): ?>
                        <option value="<?php echo htmlspecialchars($location); ?>"
                            <?php echo ($selected_location == $location) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($location); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">View Booking Counts</button>
            </form>
            <div class="chart-container">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    const ctx1 = document.getElementById('parkingChart').getContext('2d');
    const parkingChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($locations); ?>,
            datasets: [{
                data: <?php echo json_encode($locationCounts); ?>,
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Parking Spaces per Location'
                }
            }
        }
    });

    <?php if ($selected_location): ?>
    const ctx2 = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($booking_counts, 'P_parkingSpaceID')); ?>,
            datasets: [{
                label: 'Booking Count',
                data: <?php echo json_encode(array_column($booking_counts, 'booking_count')); ?>,
                backgroundColor: '#36a2eb'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Booking Counts for <?php echo htmlspecialchars($selected_location); ?>'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Parking Space ID'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Booking Count'
                    }
                }
            }
        }
    });
    <?php endif; ?>
</script>
</body>
</html>
