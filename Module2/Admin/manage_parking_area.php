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
            text-align: center;
        }
        .content-container h2 {
            margin-bottom: 20px;
        }
        .parking-image {
            position: relative;
            display: inline-block;
        }
        .parking-image img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .parking-label {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            text-align: center;
        }
        .label-A1 { top: 10%; left: 10%; }
        .label-A2 { top: 10%; left: 30%; }
        .label-A3 { top: 10%; left: 50%; }
        .label-A4 { top: 10%; left: 70%; }
        .label-B1 { top: 50%; left: 10%; }
        .label-B2 { top: 50%; left: 30%; }
        .label-B3 { top: 50%; left: 50%; }
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
        form {
            margin: 20px 0;
        }
        input[type="text"] {
            padding: 10px;
            width: 150px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
    <script>
        function closeParkingArea(event) {
            event.preventDefault();
            const area = document.getElementById('parkingArea').value;
            const table = document.getElementById('parkingTable');
            let found = false;

            for (let i = 1; i < table.rows.length; i++) {
                const row = table.rows[i];
                const locationCell = row.cells[1];

                if (locationCell.innerHTML === area) {
                    row.cells[2].innerHTML = 'Temporarily Closed';
                    found = true;
                    break;
                }
            }

            if (!found) {
                alert('Parking area not found!');
            }

            document.getElementById('parkingArea').value = '';
        }
    </script>
</head>
<body>
<div class="content-container">
    <h2>Manage Parking Area</h2>
    <div class="parking-image">
        <img src="parking_area.jpg" alt="Parking Area">
        <div class="parking-label label-A1">A1</div>
        <div class="parking-label label-A2">A2</div>
        <div class="parking-label label-A3">A3</div>
        <div class="parking-label label-A4">A4</div>
        <div class="parking-label label-B1">B1</div>
        <div class="parking-label label-B2">B2</div>
        <div class="parking-label label-B3">B3</div>
    </div>
    <form onsubmit="closeParkingArea(event)">
        <input type="text" id="parkingArea" placeholder="Enter parking area (e.g., A1)" required>
        <input type="submit" value="Close Area">
    </form>
    <table id="parkingTable">
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
                <td>Available</td>
                <td>Staff</td>
            </tr>
            <tr>
                <td>2</td>
                <td>A2</td>
                <td>Occupied</td>
                <td>Staff</td>
            </tr>
            <tr>
                <td>3</td>
                <td>A3</td>
                <td>Available</td>
                <td>Student</td>
            </tr>
            <tr>
                <td>4</td>
                <td>A4</td>
                <td>Available</td>
                <td>Student</td>
            </tr>
            <tr>
                <td>5</td>
                <td>B1</td>
                <td>Available</td>
                <td>Student</td>
            </tr>
            <tr>
                <td>6</td>
                <td>B2</td>
                <td>Occupied</td>
                <td>Student</td>
            </tr>
            <tr>
                <td>7</td>
                <td>B3</td>
                <td>Available</td>
                <td>Staff</td>
            </tr>
            <!-- Additional rows can be added here -->
        </tbody>
    </table>
</div>
</body>
</html>