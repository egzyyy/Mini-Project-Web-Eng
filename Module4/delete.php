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
    $sql = "DELETE FROM trafficSummon WHERE TF_summonID='$summonID'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: Module4/trafficSummon.php"); // Redirect to the main page
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
