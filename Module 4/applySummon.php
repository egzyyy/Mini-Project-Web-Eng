<?php
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="#">ACADEMIC</a>
            <a href="#">ABOUT</a>
            <a href="#">UNIT KESELAMATAN</a>
        </div>
    </header>
    <main>
        <section class="content">
            <h2>Add Summon</h2>
            <form action="add_summon.php" method="post">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required>
                <label for="plate_number">Plate Number:</label>
                <input type="text" id="plate_number" name="plate_number" required>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
                <button type="submit" class="apply-summon">Apply Summon</button>
            </form>
        </section>
    </main>
    <footer>
        <div class="footer-nav">
            <a href="#">Profile</a>
            <a href="#">Parking</a>
            <a href="#">Home</a>
            <a href="#">Summon</a>
            <a href="#">Dashboard</a>
            <a href="#">Vehicle</a>
        </div>
    </footer>
</body>
</html>
