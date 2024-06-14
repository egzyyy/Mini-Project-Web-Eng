<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_eng";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$summons = [];

// Check if student ID is available in the session (assuming student ID is stored in session when student logs in)
if (isset($_SESSION['STU_studentID'])) {
    $student_id = $_SESSION['STU_studentID'];

    // Fetch all vehicles registered by the student
    $sql_vehicles = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE STU_studentID = ?";
    $stmt_vehicles = $conn->prepare($sql_vehicles);
    if ($stmt_vehicles) {
        $stmt_vehicles->bind_param("i", $student_id);
        $stmt_vehicles->execute();
        $result_vehicles = $stmt_vehicles->get_result();

        // For each vehicle, fetch the latest summon details
        while ($vehicle = $result_vehicles->fetch_assoc()) {
            $vehicle_id = $vehicle['V_vehicleID'];
            $plate_number = $vehicle['V_plateNum'];

            $sql_summon = "SELECT TF_date, TF_status, TF_violationType, TF_demeritPoint
                           FROM trafficSummon
                           WHERE V_vehicleID = ?
                           ORDER BY TF_date DESC
                           LIMIT 1";  // Assuming you want the latest summon per vehicle

            $stmt_summon = $conn->prepare($sql_summon);
            if ($stmt_summon) {
                $stmt_summon->bind_param("i", $vehicle_id);
                $stmt_summon->execute();
                $result_summon = $stmt_summon->get_result();

                if ($result_summon->num_rows > 0) {
                    $summon = $result_summon->fetch_assoc();
                    $summon['plate_number'] = $plate_number;
                    $summon['enforcement_type'] = getEnforcementType((int)$summon['TF_demeritPoint']);
                    $summons[] = $summon;
                }
                $stmt_summon->close();
            }
        }
        $stmt_vehicles->close();
    }
}

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
        if (count($summons) > 0) {
            echo "<table>";
            echo "<tr><th>Plate Number</th><th>Date</th><th>Status</th><th>Violation Type</th><th>Demerit Points</th><th>Enforcement Type</th></tr>";
            foreach ($summons as $summon) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($summon['plate_number']) . "</td>";
                echo "<td>" . htmlspecialchars($summon['TF_date']) . "</td>";
                echo "<td>" . htmlspecialchars($summon['TF_status']) . "</td>";
                echo "<td>" . htmlspecialchars($summon['TF_violationType']) . "</td>";
                echo "<td>" . htmlspecialchars($summon['TF_demeritPoint']) . "</td>";
                echo "<td>" . htmlspecialchars($summon['enforcement_type']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No summon details found.</p>";
        }
        ?>
    </div>
</body>
</html>
