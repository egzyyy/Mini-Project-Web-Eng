<?php
include('../../Layout/admin_layout.php');
include('../../db.php'); // Make sure this path is correct

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['location'], $_POST['status'], $_POST['type'])) {
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $status = mysqli_real_escape_string($link, $_POST['status']);
    $type = mysqli_real_escape_string($link, $_POST['type']);

    $sql = "INSERT INTO parkingSpace (P_location, P_status, P_parkingType) VALUES ('$location', '$status', '$type')";
    if (mysqli_query($link, $sql)) {
        echo json_encode(["status" => "success", "message" => "New parking space added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($link)]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['parkingSpaceID'])) {
    $parkingSpaceID = mysqli_real_escape_string($link, $_POST['parkingSpaceID']);
    
    // Redirect to EditParkingSpace.php with the parkingSpaceID
    header("Location: EditParkingSpace.php?P_parkingSpaceID=$parkingSpaceID");
    exit;
}

// Fetch all parking spaces
$result = mysqli_query($link, "SELECT * FROM parkingSpace");
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
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Reload the page
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function deleteParkingSpace(parkingSpaceID) {
            if (confirm('Are you sure you want to delete this parking space?')) {
                fetch('delete_parking_space.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({parkingSpaceID: parkingSpaceID})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload(); // Reload the page
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function editParkingSpace(parkingSpaceID) {
    if (confirm('Are you sure you want to edit this parking space?')) {
        
        // Construct the URL with the parkingSpaceID as a query parameter
        const url = `EditParkingSpace.php?P_parkingSpaceID=${parkingSpaceID}`;

        // Navigate to EditParkingSpace.php
        window.location.href = url;
    }
}
    </script>
</head>
<body>
<div class="content-container">
    <h2>Manage Parking Space</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Location</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display parking spaces from database
            if ($result) {
                $index = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$index}</td>
                            <td>{$row['P_location']}</td>
                            <td>{$row['P_status']}</td>
                            <td>{$row['P_parkingType']}</td>
                            <td>
                                <button onclick='editParkingSpace({$row['P_parkingSpaceID']})'>Update</button>
                                <button onclick='deleteParkingSpace({$row['P_parkingSpaceID']})'>Delete</button>
                            </td>
                          </tr>";
                    $index++;
                }
            }
            ?>
        </tbody>
    </table>
    <div class="add-button-container">
        <button onclick="showAddForm()">Add New Parking Space</button>
    </div>
    <div class="form-container">
        <h2>Add New Parking Space</h2>
        <form method="post" onsubmit="addParkingSpace(event)">
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
