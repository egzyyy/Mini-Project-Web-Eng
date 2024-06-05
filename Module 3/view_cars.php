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
$tab = mysqli_query($link, $sql5); // Use mysqli_query instead of $link->query

echo "<h2>Available Cars</h2>";
if ($tab) { // Check if the query was successful
    if (mysqli_num_rows($tab) > 0) { // Use mysqli_num_rows instead of $tab->num_rows
        while ($row = mysqli_fetch_assoc($tab)) { // Use mysqli_fetch_assoc instead of $tab->fetch_assoc()
            echo "<p>Car ID: " . $row['V_vehicleID'] . "</p>";
            echo "<p>Plate Number: " . $row['V_plateNum'] . "</p>";
            echo "<p>Vehicle Type: " . $row['V_vehicleType'] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No cars found.";
    }
} else {
    echo "Error executing query: " . mysqli_error($link); // Display error message if query fails
}

// Close the connection
mysqli_close($link);
?>
