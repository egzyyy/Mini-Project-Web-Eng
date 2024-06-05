<?php
// Include the database connection file
include ('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $qr_code = mysqli_real_escape_string($conn, $_POST['qr_code']);

    // Insert parking information into the database
    $parking_sql = "INSERT INTO parking (qr_code, duration) VALUES ('$qr_code', '$duration')";
    if ($conn->query($parking_sql) === TRUE) {
        echo "<h2>Parking Confirmation</h2>";
        echo "<p>Duration: $duration hours</p>";
        echo "<p>QR Code: $qr_code</p>";
    } else {
        echo "Error: " . $parking_sql . "<br>" . $conn->error;
    }
} else {
?>
    <h2>Park Your Car</h2>
    <form method="post" action="parking.php">
        <div class="form-group">
            <label for="qr_code">QR Code:</label>
            <input type="text" id="qr_code" name="qr_code" required>
        </div>
        <div class="form-group">
            <label for="duration">Expected Parking Duration (hours):</label>
            <input type="number" id="duration" name="duration" required>
        </div>
        <div class="form-group">
            <button type="submit">Confirm Parking</button>
        </div>
    </form>
<?php
}
?>
