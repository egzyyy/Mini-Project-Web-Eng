<?php
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

if (isset($_GET['id'])) {
    $summonID = $_GET['id'];
    $sql = "UPDATE trafficSummon SET status='Cancelled' WHERE TF_summonID='$summonID'";

    if ($conn->query($sql) === TRUE) {
        echo "Record cancelled successfully";
        header("Location: Module4/trafficSummon.php"); // Redirect to the main page
    } else {
        echo "Error cancelling record: " . $conn->error;
    }
}

$conn->close();
?>
