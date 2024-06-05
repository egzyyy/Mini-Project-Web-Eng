<?php
include('../../Layout/admin_layout.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Car Park Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);

        }
        .content-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        .status-available {
            color: green;
            font-weight: bold;
        }
        .status-occupied {
            color: red;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="content-container">
        <h2>Daily Available Parking Area</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example rows for demonstration purposes -->
                <tr>
                    <td>1</td>
                    <td>A1</td>
                    <td class="status-available">Available</td>
                    <td>Staff</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>A2</td>
                    <td class="status-occupied">Occupied</td>
                    <td>Staff</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>B1</td>
                    <td class="status-available">Available</td>
                    <td>Student</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>B2</td>
                    <td class="status-occupied">Occupied</td>
                    <td>Student</td>
                </tr>
                <!-- Additional rows can be added here -->
            </tbody>
        </table>
    </div>

</body>
</html>