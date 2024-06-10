<?php
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['location'], $_POST['status'])) {
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $status = mysqli_real_escape_string($link, $_POST['status']);

    if ($status === 'Occupied') {
        $status = 'Temporary Closed';
    }

    $sql = "UPDATE parkingSpace SET P_status='$status' WHERE P_location='$location'";
    if (mysqli_query($link, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($link)]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
