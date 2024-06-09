<?php
include('../../db.php'); // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['parkingSpaceID'], $_POST['location'], $_POST['status'], $_POST['type'])) {
    $parkingSpaceID = mysqli_real_escape_string($link, $_POST['parkingSpaceID']);
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $status = mysqli_real_escape_string($link, $_POST['status']);
    $type = mysqli_real_escape_string($link, $_POST['type']);

    $sql = "UPDATE parkingSpace SET P_location = '$location', P_status = '$status', P_parkingType = '$type' WHERE P_parkingSpaceID = $parkingSpaceID";
    if (mysqli_query($link, $sql)) {
        header("Location: manage_parking.php"); // Redirect back to the parking management page after update
        exit;
    } else {
        echo "Error: " . mysqli_error($link);
    }
} else {
    echo "Error: Invalid request.";
}
?>
