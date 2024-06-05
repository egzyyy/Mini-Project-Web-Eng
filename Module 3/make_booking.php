<?php
// Include the database connection file
include ('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $car = mysqli_real_escape_string($conn, $_POST['car']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    // Check for clashing bookings
    $check_sql = "SELECT * FROM booking WHERE B_startTime <= '$time' AND B_endTime >= '$time' AND P_parkingSpaceID = '$car'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<p>Booking clash detected. Please choose another time or parking space.</p>";
    } else {
        // Insert booking into the database
        $insert_sql = "INSERT INTO booking (B_startTime, B_endTime, P_parkingSpaceID) VALUES ('$date $time', DATE_ADD('$date $time', INTERVAL 1 HOUR), '$car')";
        if ($conn->query($insert_sql) === TRUE) {
            // Generate QR code logic here (placeholder)
            $qr_code = "generated_qr_code_for_booking";

            echo "<h2>Booking Confirmation</h2>";
            echo "<p>Car: $car</p>";
            echo "<p>Date: $date</p>";
            echo "<p>Time: $time</p>";
            echo "<p>QR Code: $qr_code</p>";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
} else {
?>
    <h2>Make a Booking</h2>
    <form method="post" action="make_booking.php">
        <div class="form-group">
            <label for="car">Car:</label>
            <select name="car" id="car">
                <!-- Options should be dynamically generated from the database -->
                <?php
                $car_sql = "SELECT * FROM vehicle";
                $car_result = $conn->query($car_sql);
                while ($car_row = $car_result->fetch_assoc()) {
                    echo "<option value='" . $car_row['V_vehicleID'] . "'>" . $car_row['V_plateNum'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div class="form-group">
            <button type="submit">Confirm Booking</button>
        </div>
    </form>
<?php
}
?>
