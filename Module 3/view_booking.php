<?php
// Include the database connection file
include ('../db.php');

// Retrieve bookings from the database
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);

echo "<h2>Your Bookings</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Booking ID: " . $row['B_bookingID'] . "</p>";
        echo "<p>Start Time: " . $row['B_startTime'] . "</p>";
        echo "<p>End Time: " . $row['B_endTime'] . "</p>";
        echo "<p>Parking Space ID: " . $row['P_parkingSpaceID'] . "</p>";
        echo "<hr>";
    }
} else {
    echo "No bookings found.";
}
?>
