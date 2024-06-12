<?php
include('../../Layout/admin_layout.php');
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Fetch parking spaces status
$fixed_locations = ['A1', 'A2', 'A3', 'A4', 'B1', 'B2', 'B3'];
$parking_statuses = [];

// Updated query to also fetch the reason
$parking_sql = "SELECT P_location, P_status, P_reason FROM parkingSpace WHERE P_location IN ('" . implode("','", $fixed_locations) . "')";
$parking_result = $link->query($parking_sql);

while ($parking_row = $parking_result->fetch_assoc()) {
    $parking_statuses[$parking_row['P_location']] = [
        'status' => $parking_row['P_status'],
        'reason' => $parking_row['P_reason']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Parking Area</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
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
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #333;
            color: white;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
    </style>
    <script>
        function updateParkingStatus(location, status) {
            let reason = 'None';
            if (status === 'Temporary Closed') {
                reason = prompt("Please enter the reason to close the area:");
                if (!reason) {
                    alert("Reason is required to close the area.");
                    return;
                }
            }
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_parking_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('status-' + location).innerHTML = status === 'Occupied' ? 'Temporary Closed' : status;
                        document.getElementById('reason-' + location).innerHTML = reason;
                    } else {
                        alert("Failed to update status: " + response.message);
                    }
                }
            };
            xhr.send("location=" + location + "&status=" + status + "&reason=" + encodeURIComponent(reason));
        }
    </script>
</head>
<body>
<div class="content-container">
    <h2>Manage Parking Area</h2>
    <table>
        <thead>
            <tr>
                <th>Location</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($fixed_locations as $location) {
                $status = isset($parking_statuses[$location]['status']) ? $parking_statuses[$location]['status'] : 'Unknown';
                $reason = isset($parking_statuses[$location]['reason']) ? $parking_statuses[$location]['reason'] : '';
                echo "<tr>";
                echo "<td>{$location}</td>";
                echo "<td id='status-{$location}'>{$status}</td>";
                echo "<td id='reason-{$location}'>{$reason}</td>";
                echo "<td>
                        <button onclick=\"updateParkingStatus('{$location}', 'Available')\">Open</button>
                        <button onclick=\"updateParkingStatus('{$location}', 'Temporary Closed')\">Close</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
