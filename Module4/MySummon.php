<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Summon</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .content-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
        .content-container h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include('../Layout/student_layout.php'); ?>
    <div class="content-container">
        <h2>My Summon</h2>
        <?php
        if (isset($_SESSION['summon'])) {
            $summon = $_SESSION['summon'];
            // Determine enforcement type based on demerit points
            $demerit_points = (int) $summon['demerit_points'];
            $enforcement_type = getEnforcementType($demerit_points);

            echo "<table>";
            echo "<tr><th>Plate Number</th><th>Date</th><th>Status</th><th>Violation Type</th><th>Demerit Points</th><th>Enforcement Type</th><th>QR Code</th></tr>";
            echo "<tr>";
            echo "<td>" . htmlspecialchars($summon['plate_number']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['date']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['status']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['violation_type']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['demerit_points']) . "</td>";
            echo "<td>" . htmlspecialchars($enforcement_type) . "</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "<p>No summon details found.</p>";
        }

        // Function to get enforcement type based on demerit points
        function getEnforcementType($demerit_points) {
            if ($demerit_points < 20) {
                return "Warning given";
            } elseif ($demerit_points < 50) {
                return "Revoke of in campus vehicle permission for 1 semester";
            } elseif ($demerit_points < 80) {
                return "Revoke of in campus vehicle permission for 2 semesters";
            } else {
                return "Revoke of in campus vehicle permission for the entire study duration";
            }
        }
        ?>
        <div class="button-container">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
