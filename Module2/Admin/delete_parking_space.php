<?php
include('../../db.php'); // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['parkingSpaceID'])) {
    $parkingSpaceID = mysqli_real_escape_string($link, $_POST['parkingSpaceID']);

    $sql = "DELETE FROM parkingSpace WHERE P_parkingSpaceID = $parkingSpaceID";
    if (mysqli_query($link, $sql)) {
        echo json_encode(["status" => "success", "message" => "Parking space deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($link)]);
    }
    exit;
}
?>
