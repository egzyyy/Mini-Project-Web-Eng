<?php
if (isset($_GET['id'])) {
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

    $id = $_GET['id'];

    $sql = "DELETE FROM trafficSummon WHERE TF_summonID = '$id' AND status = 'Paid'";

    if ($conn->query($sql) === TRUE) {
        echo "Summon deleted successfully";
    } else {
        echo "Error deleting summon: " . $conn->error;
    }

    $conn->close();
    header("Location: index.php");
}
?>
