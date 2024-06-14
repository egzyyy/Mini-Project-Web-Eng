<?php
session_start();
require('../Layout/staff_layout.php');

// Database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Retrieve total summon count
$sql_total_summons = "SELECT COUNT(*) AS total_summons FROM trafficSummon";
$result_total_summons = mysqli_query($link, $sql_total_summons);

if ($result_total_summons) {
    $row_total_summons = mysqli_fetch_assoc($result_total_summons);
    $total_summons = $row_total_summons['total_summons'];
} else {
    $total_summons = 0;
}

// Retrieve violation type statistics
$sql_violations = "SELECT TF_violationType, COUNT(*) AS total_violations FROM trafficSummon GROUP BY TF_violationType";
$result_violations = mysqli_query($link, $sql_violations);

$violation_types = [];
$total_violations = [];

while ($row = mysqli_fetch_assoc($result_violations)) {
    $violation_types[] = $row['TF_violationType'];
    $total_violations[] = (int)$row['total_violations'];
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon Report Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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

        #violationPieChartContainer {
            width: 80%;
            margin: auto;
            height: 400px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-content">
            <div class="dashboard-header">
                <div class="dashboard-title">Summon Report Dashboard</div>
            </div>
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <div class="card-title">Total Summons</div>
                    <div class="card-content"><?php echo $total_summons; ?></div>
                </div>
            </div>
            <div id="violationPieChartContainer">
                <canvas id="violationPieChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctxPie = document.getElementById('violationPieChart').getContext('2d');

            // Prepare data for the pie chart
            var violationTypes = <?php echo json_encode($violation_types); ?>;
            var totalViolations = <?php echo json_encode($total_violations); ?>;

            // Create the pie chart
            var violationPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: violationTypes,
                    datasets: [{
                        label: 'Violation Types',
                        data: totalViolations,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
