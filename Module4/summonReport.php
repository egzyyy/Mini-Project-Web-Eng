<?php
session_start();
include('../Layout/staff_layout.php'); 
// Database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
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
    <style>
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            max-width: 600px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Violation Type Dashboard</h2>
        <!-- Violation Type Statistics Table -->
        <table>
            <thead>
                <tr>
                    <th>Violation Type</th>
                    <th>Total Summons</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($violation_types); $i++): ?>
                    <tr>
                        <td><?= $violation_types[$i]; ?></td>
                        <td><?= $total_violations[$i]; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
