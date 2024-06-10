<?php
include('../Layout/student_layout.php');
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

mysqli_select_db($link, "web_eng");

// Check if form is submitted and the confirm booking button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $B_bookingID = $_POST['B_bookingID'];
    $B_startTime = $_POST['B_startTime'];
    $B_endTime = $_POST['B_endTime'];
    $P_parkingspaceID = $_POST['P_parkingspaceID'];

    // Get the vehicle ID based on the selected car
    $selectedCarID = $_POST['car'];
    $sql = "SELECT V_plateNum FROM vehicle WHERE V_vehicleID = '$selectedCarID'";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $P_parkingspaceID = $row['V_plateNum'];

        // Insert the booking
        $sql = "INSERT INTO booking (B_bookingID, B_startTime, B_endTime, P_parkingSpaceID)
                VALUES ('$B_bookingID', '$B_startTime', '$B_endTime', '$P_parkingspaceID')";

        if ($link->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Booking added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $link->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Booking failed.</div>";
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
                <label for="car">Car:</label>
                <select name="car" id="car" required>
                    <!-- Options should be dynamically generated from the database -->
                    <?php
                    $car_sql = "SELECT * FROM vehicle";
                    $car_result = $link->query($car_sql);
                    while ($car_row = $car_result->fetch_assoc()) {
                        echo "<option value='" . $car_row['V_vehicleID'] . "'>" . $car_row['V_plateNum'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="B_startTime">Start Time:</label>
                <input type="datetime-local" id="B_startTime" name="B_startTime" required>
            </div>
            <div class="form-group">
                <label for="B_endTime">End Time:</label>
                <input type="datetime-local" id="B_endTime" name="B_endTime" required>
            </div>
            <div class="form-group">
                <button type="submit">Confirm Booking</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
// Closing PHP tag at the end of the script
?>
