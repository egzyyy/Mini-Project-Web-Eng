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
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .content-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-container, .add-button {
            display: none;
            margin-top: 20px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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
        .add-button-container {
            text-align: right;
            margin-top: 20px;
        }
        .add-button-container button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-button-container button:hover {
            background-color: #555;
        }
    </style>
    <script>
        function showAddForm() {
            document.querySelector('.form-container').style.display = 'block';
        }

        function addParkingSpace(event) {
            event.preventDefault();
            // Add your form submission logic here
            alert('Parking space added!');
        }
    </script>
</head>
<body>
<div class="content-container">
    <h2>Manage Parking Space</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Location</th>
                <th>Status</th>
                <th>Type</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example rows for demonstration purposes -->
            <tr>
                <td>1</td>
                <td>A1</td>
                <td>Available</td>
                <td>Staff</td>
                <td><img src="example_qr.png" alt="QR Code" style="width: 50px;"></td>
                <td>
                    <form action="#" method="post" style="display:inline-block;">
                        <button type="submit">Update</button>
                    </form>
                    <form action="#" method="post" style="display:inline-block;">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>B2</td>
                <td>Occupied</td>
                <td>Student</td>
                <td><img src="example_qr.png" alt="QR Code" style="width: 50px;"></td>
                <td>
                    <form action="#" method="post" style="display:inline-block;">
                        <button type="submit">Update</button>
                    </form>
                    <form action="#" method="post" style="display:inline-block;">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <!-- Additional rows can be added here -->
        </tbody>
    </table>
    <div class="add-button-container">
        <button onclick="showAddForm()">Add New Parking Space</button>
    </div>
    <div class="form-container">
        <h2>Add New Parking Space</h2>
        <form onsubmit="addParkingSpace(event)">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>
            
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
            </select>
            
            <label for="type">Parking Type</label>
            <select id="type" name="type" required>
                <option value="staff">Staff</option>
                <option value="student">Student</option>
            </select>
            
            <button type="submit">Add Parking Space</button>
        </form>
    </div>
</div>
</body>
</html>