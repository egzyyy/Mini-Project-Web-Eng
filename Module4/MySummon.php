<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "web_eng";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if plate number is available in the session
if (isset($_SESSION['summon']['plate_number'])) {
    $plate_number = $_SESSION['summon']['plate_number'];

    // Fetch the latest summon details using the plate number
    $sql = "SELECT t.TF_date, t.TF_status, t.TF_violationType, t.TF_demeritPoint
            FROM trafficSummon t
            JOIN vehicle v ON t.V_vehicleID = v.V_vehicleID
            WHERE v.V_plateNum = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $plate_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $summon = $result->fetch_assoc();
        $demerit_points = (int) $summon['TF_demeritPoint'];
        $enforcement_type = getEnforcementType($demerit_points);
    } else {
        $summon = null;
    }
} else {
    $summon = null;
}

$stmt->close();
$conn->close();

// Function to get enforcement type based on demerit points
function getEnforcementType($demerit_points) {
    if ($demerit_points < 20) {
        return "Warning given";
    } elseif ($demerit_points < 50) {
        return "Revoke of in-campus vehicle permission for 1 semester";
    } elseif ($demerit_points < 80) {
        return "Revoke of in-campus vehicle permission for 2 semesters";
    } else {
        return "Revoke of in-campus vehicle permission for the entire study duration";
    }
}
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

    </style>
</head>
<body>
    <?php include('../Layout/student_layout.php'); ?>
    <div class="content-container">
        <h2>My Summon</h2>
        <?php
        if ($summon) {
            echo "<table>";
            echo "<tr><th>Plate Number</th><th>Date</th><th>Status</th><th>Violation Type</th><th>Demerit Points</th><th>Enforcement Type</th></tr>";
            echo "<tr>";
            echo "<td>" . htmlspecialchars($_SESSION['summon']['plate_number']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['TF_date']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['TF_status']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['TF_violationType']) . "</td>";
            echo "<td>" . htmlspecialchars($summon['TF_demeritPoint']) . "</td>";
            echo "<td>" . htmlspecialchars($enforcement_type) . "</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "<p>No summon details found.</p>";
        }
        ?>
    </div>
</body>
</html>
