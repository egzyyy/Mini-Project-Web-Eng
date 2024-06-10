<?php
include('../../Layout/admin_layout.php');
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Fetch parking spaces
$parking_sql = "SELECT * FROM parkingSpace";
$parking_result = $link->query($parking_sql);
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
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_parking_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('status-' + location).innerHTML = status;
                    } else {
                        alert("Failed to update status: " + response.message);
                    }
                }
            };
            xhr.send("location=" + location + "&status=" + status);
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($parking_row = $parking_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$parking_row['P_location']}</td>";
                echo "<td id='status-{$parking_row['P_location']}'>{$parking_row['P_status']}</td>";
                echo "<td>
                        <button onclick=\"updateParkingStatus('{$parking_row['P_location']}', 'Open')\">Open</button>
                        <button onclick=\"updateParkingStatus('{$parking_row['P_location']}', 'Close')\">Close</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
