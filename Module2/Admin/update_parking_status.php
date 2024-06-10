<?php
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $status = mysqli_real_escape_string($link, $_POST['status']) === 'Close' ? 'Temporarily Closed' : 'Available';

    $update_sql = "UPDATE parkingSpace SET P_status = '$status' WHERE P_location = '$location'";

    if ($link->query($update_sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $link->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
