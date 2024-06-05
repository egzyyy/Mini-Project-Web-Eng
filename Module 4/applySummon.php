<?php
include('../Layout/staff_layout.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $student_id = $_POST['student_id'];
    $plate_number = $_POST['plate_number'];
    $violation_type = $_POST['violation_type'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Get the vehicle ID based on the plate number
    $sql = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum='$plate_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vehicle_id = $row['V_vehicleID'];

        // Insert the summon
        $sql = "INSERT INTO trafficSummon (V_vehicleID, student_id, date, status, plate_number)
                VALUES ('$vehicle_id', '$student_id', '$date', '$status', '$plate_number')";

        if ($conn->query($sql) === TRUE) {
            echo "New summon added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No vehicle found with that plate number.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Summon</title>
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

        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }

        .content-container h2 {
            margin-bottom: 20px;
        }

        /* Form styling */
        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
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
        button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #575757;
        }

    </style>
</head>
<body>
    <div class="content-container">
        <h2>Add Summon</h2>
        <form action="add_summon.php" method="post">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="plate_number">Plate Number:</label>
                <input type="text" id="plate_number" name="plate_number" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
            </div>
            <button type="submit" class="apply-summon">Apply Summon</button>
        </form>
    </div>
</body>
</html>

