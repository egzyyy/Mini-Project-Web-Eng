<?php
// Include the database connection file
include ('../db.php');

// Connect to the MySQL server using mysqli
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Retrieve cars from the database
$sql5 = "SELECT * FROM vehicle";
$tab = $link->query($sql5);

echo "<h2>Available Cars</h2>";
if ($tab->num_rows > 0) {
    while ($row = $tab->fetch_assoc()) {
        echo "<p>Car ID: " . $row['V_vehicleID'] . "</p>";
        echo "<p>Plate Number: " . $row['V_plateNum'] . "</p>";
        echo "<p>Vehicle Type: " . $row['V_vehicleType'] . "</p>";
        echo "<hr>";
    }
} else {
    echo "No cars found.";
}

// Close the connection
mysqli_close($link);
?>