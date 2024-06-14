<?php
session_start();
require('../../Layout/student_layout.php');

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Query to count the total number of vehicles registered
$query_total_vehicles = "SELECT COUNT(*) AS total_vehicles FROM vehicle";
$result_total_vehicles = mysqli_query($link, $query_total_vehicles);

if ($result_total_vehicles) {
    $row_total_vehicles = mysqli_fetch_assoc($result_total_vehicles);
    $total_vehicles = $row_total_vehicles['total_vehicles'];
} else {
    $total_vehicles = 0;
}

// Query to count the total number of cars and motorcycles
$query_car_count = "SELECT COUNT(*) AS car_count FROM vehicle WHERE V_vehicleType = 'Car'";
$result_car_count = mysqli_query($link, $query_car_count);

if ($result_car_count) {
    $row_car_count = mysqli_fetch_assoc($result_car_count);
    $total_cars = $row_car_count['car_count'];
} else {
    $total_cars = 0;
}

$query_motorcycle_count = "SELECT COUNT(*) AS motorcycle_count FROM vehicle WHERE V_vehicleType = 'Motorcycle'";
$result_motorcycle_count = mysqli_query($link, $query_motorcycle_count);

if ($result_motorcycle_count) {
    $row_motorcycle_count = mysqli_fetch_assoc($result_motorcycle_count);
    $total_motorcycles = $row_motorcycle_count['motorcycle_count'];
} else {
    $total_motorcycles = 0;
}

// Query to get the counts for each brand
$query_brand_counts = "SELECT V_brand, COUNT(*) AS brand_count FROM vehicle GROUP BY V_brand";
$result_brand_counts = mysqli_query($link, $query_brand_counts);

$brands = [];
$brandCounts = [];

if ($result_brand_counts) {
    while ($row_brand_counts = mysqli_fetch_assoc($result_brand_counts)) {
        $brands[] = $row_brand_counts['V_brand'];
        $brandCounts[] = $row_brand_counts['brand_count'];
    }
} else {
    // Default example data if no data found
    $brands = ['Perodua', 'Honda', 'Toyota', 'Wolkswagen'];
    $brandCounts = [10, 15, 8, 12];
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

        .avatar {
            height: 10px;
            width: 10px;
            border-radius: 50%;
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
    </style>
</head>
<body>
    <center>
        <h2>Hello, <?php echo $_SESSION['STU_name']; ?></h2>
    </center>
    <div class="dashboard-container">
        <div class="dashboard-content">
            <div class="dashboard-header">
                <div class="dashboard-title">Dashboard</div>
            </div>
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <div class="card-title">My Car Registered</div>
                    <div class="card-content"><?php echo $total_cars; ?></div>
                </div>
                <div class="dashboard-card">
                    <div class="card-title">My Motorcycle Registered</div>
                    <div class="card-content"><?php echo $total_motorcycles; ?></div>
                </div>
                <div class="dashboard-card">
                    <div class="card-title">Total Registered Vehicles</div>
                    <div class="card-content"><?php echo $total_vehicles; ?></div>
                </div>
                <!-- Add more cards as needed -->
            </div>
            <div style="width: 50%; margin-top: 20px; margin-left:230px;">
                <canvas id="brandBarChart" width="400" height="200"></canvas>
                <canvas id="brandPieChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the canvas elements
            var ctxBar = document.getElementById('brandBarChart').getContext('2d');
            var ctxPie = document.getElementById('brandPieChart').getContext('2d');

            // Prepare data for the charts
            var brands = <?php echo json_encode($brands); ?>;
            var brandCounts = <?php echo json_encode($brandCounts); ?>;

            // Create the bar chart
            var brandBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: brands,
                    datasets: [{
                        label: 'Brand Counts',
                        data: brandCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 0.5
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Create the pie chart
            var brandPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: brands,
                    datasets: [{
                        label: 'Brand Distribution',
                        data: brandCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 0.5
                    }]
                }
            });
        });
    </script>
</body>
</html>
