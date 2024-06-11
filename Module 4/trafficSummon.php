<?php
include('../Layout/staff_layout.php');

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

// Handle update action
if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
    $summon_id = $_GET['id'];

    // Update status to 'Paid' with prepared statements
    $stmt = $conn->prepare("UPDATE trafficSummon SET TF_status = 'Paid' WHERE TF_summonID = ?");
    $stmt->bind_param("i", $summon_id);

    if ($stmt->execute()) {
        echo "<script>alert('Summon updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

// Handle cancel action
if (isset($_GET['action']) && $_GET['action'] == 'cancel' && isset($_GET['id'])) {
    $summon_id = $_GET['id'];

    // Update status to 'Cancelled' with prepared statements
    $stmt = $conn->prepare("UPDATE trafficSummon SET TF_status = 'Cancelled' WHERE TF_summonID = ?");
    $stmt->bind_param("i", $summon_id);

    if ($stmt->execute()) {
        echo "<script>alert('Summon cancelled successfully');</script>";
    } else {
        echo "<script>alert('Error cancelling summon: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $summon_id = $_GET['id'];

    // Delete summon from database with prepared statements
    $stmt = $conn->prepare("DELETE FROM trafficSummon WHERE TF_summonID = ?");
    $stmt->bind_param("i", $summon_id);

    if ($stmt->execute()) {
        echo "<script>alert('Summon deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting summon: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

// Fetch summons from database
$sql = "SELECT * FROM trafficSummon";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Summons</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        /* Main content container */
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

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Form styling */
        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            margin-top: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            border-radius: 4px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="date"],
        form select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-update {
            background-color: #28a745;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .btn-cancel {
            background-color: #ffc107;
        }

        .btn-cancel:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Traffic Summons</h2>
        <table>
            <thead>
                <tr>
                    <th>Summon ID</th>
                    <th>Vehicle ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Plate Number</th>
                    <th>Violation Type</th>
                    <th>Demerit Points</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["TF_summonID"] . "</td>";
                        echo "<td>" . $row["V_vehicleID"] . "</td>";
                        echo "<td>" . $row["TF_date"] . "</td>";
                        echo "<td>" . $row["TF_status"] . "</td>";
                        echo "<td>" . $row["plate_number"] . "</td>";
                        echo "<td>" . $row["TF_violationType"] . "</td>";
                        echo "<td>" . $row["TF_demeritPoint"] . "</td>";
                        echo '<td>';
                        if ($row["TF_status"] == "Unpaid") {
                            echo '<a href="trafficSummon.php?action=update&id=' . $row["TF_summonID"] . '" class="btn btn-update">Update</a>';
                            echo '<a href="trafficSummon.php?action=cancel&id=' . $row["TF_summonID"] . '" class="btn btn-cancel">Cancel</a>';
                        } else {
                            echo '<a href="trafficSummon.php?action=delete&id=' . $row["TF_summonID"] . '" class="btn btn-delete">Delete</a>';
                        }
                        echo '</td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No summons found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>