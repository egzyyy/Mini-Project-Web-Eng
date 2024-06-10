<?php
include('../Layout/student_layout.php');
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if form is submitted and the apply-summon button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    if (isset($_POST['V_plateNum']) && isset($_POST['P_parkingspaceID'])) {
        $V_plateNum = $_POST['V_plateNum'];
        $B_startTime = $_POST['B_startTime'];
        $B_endTime = $_POST['B_endTime'];
        $P_parkingspaceID = $_POST['P_parkingspaceID'];

        // Insert the booking
        $sql = "INSERT INTO booking (B_startTime, B_endTime, P_parkingSpaceID)
                VALUES ('$B_startTime', '$B_endTime', '$P_parkingspaceID')";

        if ($link->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Booking added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $link->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Booking failed. Missing required fields.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        form {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin: 10px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select,
        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .form-group button {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #555;
        }
        .message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Make a Booking</h2>
        <form method="post" action="make_booking.php">
            <div class="form-group">
                <label for="V_plateNum">Vehicle Plate Number:</label>
                <select name="V_plateNum" id="V_plateNum" required>
                    <?php
                    $sql = "SELECT V_plateNum FROM vehicle";
                    $result = $link->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['V_plateNum'] . "'>" . $row['V_plateNum'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="B_startTime">Start Time:</label>
                <input type="time" id="B_startTime" name="B_startTime" required>
            </div>
            <div class="form-group">
                <label for="B_endTime">End Time:</label>
                <input type="time" id="B_endTime" name="B_endTime" required>
            </div>
            <div class="form-group">
                <label for="P_parkingspaceID">Parking Space ID:</label>
                <select name="P_parkingspaceID" id="P_parkingspaceID" required>
                    <?php
                    $sql = "SELECT P_parkingSpaceID FROM parkingSpace";
                    $result = $link->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['P_parkingSpaceID'] . "'>" . $row['P_parkingSpaceID'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Confirm Booking</button>
            </div>
        </form>
    </div>
</body>
</html>