<?php
session_start();
include('../../Layout/admin_layout.php');
include('../../phpqrcode/qrlib.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

mysqli_select_db($link, "web_eng");

// Function to generate the next parking space ID
function generateParkingSpaceID($prefix, $link) {
    $query = "SELECT P_parkingSpaceID FROM parkingSpace WHERE P_parkingSpaceID LIKE '$prefix%' ORDER BY P_parkingSpaceID DESC LIMIT 1";
    $result = mysqli_query($link, $query);
    $lastID = mysqli_fetch_assoc($result)['P_parkingSpaceID'];
    
    if ($lastID) {
        $number = (int)substr($lastID, strlen($prefix)) + 1;
    } else {
        $number = 1;
    }
    
    return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['location'], $_POST['status'], $_POST['type'])) {
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $status = mysqli_real_escape_string($link, $_POST['status']);
    $type = mysqli_real_escape_string($link, $_POST['type']);
    
    // Determine the prefix based on the parking type
    $prefix = $type == 'Student' ? 'SS' : 'PS';
    $parkingSpaceID = generateParkingSpaceID($prefix, $link);

    $sql = "INSERT INTO parkingSpace (P_parkingSpaceID, P_location, P_status, P_parkingType) VALUES ('$parkingSpaceID', '$location', '$status', '$type')";
    header('Content-Type: application/json');

    // QR code generation
    $qrCodeDir = "../../QRImage";
    if (!is_dir($qrCodeDir)) {
        mkdir($qrCodeDir, 0755, true);
    }

    // Generate QR Code with the full URL
    $qrCodeData = "http://localhost/projectWeb/Mini-Project-Web-Eng/Module2/Admin/view_parking.php?P_parkingSpaceID=$parkingSpaceID";    
    $qrCodeFile = $qrCodeDir . "/parking" . $parkingSpaceID . ".png";
    QRcode::png($qrCodeData, $qrCodeFile, QR_ECLEVEL_L, 5);

    if (mysqli_query($link, $sql)) {
        echo json_encode(["status" => "success", "message" => "New parking space added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($link)]);
    }
    exit;
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteParkingSpaceID'])) {
    $parkingSpaceID = mysqli_real_escape_string($link, $_POST['deleteParkingSpaceID']);

    $sql = "DELETE FROM parkingSpace WHERE P_parkingSpaceID = '$parkingSpaceID'";
    if (mysqli_query($link, $sql)) {
        echo json_encode(["status" => "success", "message" => "Parking space deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($link)]);
    }
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
        .form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            border-radius: 10px;
            z-index: 1000;
            width: 400px;
            max-width: 90%;
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
        .form-container .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
    <script>
        function showAddForm() {
            document.querySelector('.form-container').style.display = 'block';
        }

        function hideAddForm() {
            document.querySelector('.form-container').style.display = 'none';
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
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the parking space.');
            });
        }

        function deleteParkingSpace(parkingSpaceID) {
            if (confirm('Are you sure you want to delete this parking space?')) {
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({deleteParkingSpaceID: parkingSpaceID})
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

        function filterLocationType() {
            const idInput = document.getElementById('parkingSpaceID');
            const locationSelect = document.getElementById('location');
            const typeInput = document.getElementById('type');
            
            locationSelect.innerHTML = ''; // Clear previous options

            if (idInput.value.startsWith('SS')) {
                locationSelect.innerHTML = `
                    <option value="" disable selected>Please Choose Location</option>
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                    <option value="B3">B3</option>
                `;
                typeInput.value = 'Student';
            } else if (idInput.value.startsWith('PS')) {
                locationSelect.innerHTML = `
                    <option value="" disable selected>Please Choose Location</option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                `;
                typeInput.value = 'Staff';
            } else {
                locationSelect.innerHTML = '<option value="" disable selected>Please Enter a Valid ID</option>';
                typeInput.value = '';
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
                <th>ID</th>
                <th>Location</th>
                <th>Status</th>
                <th>Type</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display parking spaces from database
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Path to the QR code image
                    $qrCodePath = "../../QRImage/parking" . $row['P_parkingSpaceID'] . ".png";

                    echo "<tr>
                            <td>{$row['P_parkingSpaceID']}</td>
                            <td>{$row['P_location']}</td>
                            <td>{$row['P_status']}</td>
                            <td>{$row['P_parkingType']}</td>
                            <td><img src='$qrCodePath' alt='QR Code' width='100' height='100'></td>
                            <td>
                                <button onclick='editParkingSpace(\"{$row['P_parkingSpaceID']}\")'>Update</button>
                                <button onclick='deleteParkingSpace(\"{$row['P_parkingSpaceID']}\")'>Delete</button>
                            </td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <div class="add-button-container">
        <button onclick="showAddForm()">Add New Parking Space</button>
    </div>
    <div class="form-container">
        <button class="close-btn" onclick="hideAddForm()">&times;</button>
        <h2>Add New Parking Space</h2>
        <form method="post" onsubmit="addParkingSpace(event)">
            <label for="parkingSpaceID">Parking Space ID</label>
            <select id="parkingSpaceID" name="parkingSpaceID" onchange="filterLocationType()" required>
                <option value="" disabled selected>Select Parking Type</option>
                <option value="PS">PS for Parking Staff</option>
                <option value="SS">SS for Parking Student</option>
            </select>

            <label for="type">Parking Type</label>
            <input type="text" id="type" name="type" readonly required>

            <label for="location">Location</label>
            <select id="location" name="location" required>
                <option value="" disable selected>Please Enter Parking Space ID First</option>
            </select>
            
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="" disable selected>Please Choose</option>
                <option value="Available">Available</option>
                <option value="Temporary Closed">Temporary Closed</option>
            </select>

            <button type="submit">Add Parking Space</button>
        </form>
    </div>
</div>
</body>
</html>
