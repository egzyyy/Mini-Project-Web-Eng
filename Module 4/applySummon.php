<?php

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if form is submitted and the apply-summon button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = $_POST['student_id'];
    $plate_number = $_POST['plate_number'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Get the vehicle ID based on the plate number
    $sql = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum='$plate_number'";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vehicle_id = $row['V_vehicleID'];

        // Insert the summon
        $sql = "INSERT INTO trafficSummon (V_vehicleID, student_id, date, status, plate_number)
                VALUES ('$vehicle_id', '$student_id', '$date', '$status', '$plate_number')";

        if ($link->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>New summon added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $link->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>No vehicle found with that plate number.</div>";
    }
}

// Close the database connection
mysqli_close($link);
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
            margin-left: 425px;
            padding: 20px;
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

        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-group label {
            flex: 1;
            text-align: left;
            margin-right: 10px;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select {
            flex: 2;
            width: calc(100% - 22px);
            padding: 10px;
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
            background-color: #800000;
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
    <?php include('../Layout/staff_layout.php'); ?>
    <div class="content-container">
        <h2>Add Summon</h2>
        <form action="applySummon.php" method="post">
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
            <button type="submit" name="apply-summon">Apply Summon</button>
        </form>
    </div>
</body>
</html>
