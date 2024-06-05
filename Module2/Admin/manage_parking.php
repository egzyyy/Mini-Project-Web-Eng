<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Area</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Manage Parking Area</h2>
        <form>
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
                <td><img src="example_qr.png" alt="QR Code"></td>
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
                <td><img src="example_qr.png" alt="QR Code"></td>
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
</body>
</html>
