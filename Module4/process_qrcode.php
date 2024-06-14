<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data'])) {
    // Decode the JSON data from the QR code
    $summon_data = json_decode($_POST['data'], true);

    // Check if the data is valid JSON
    if ($summon_data !== null && is_array($summon_data)) {
        // Store the summon data in the session
        $_SESSION['scanned_summon'] = $summon_data;

        // Redirect to the display page
        header("Location: displaySummon.php");
        exit;
    } else {
        echo "Invalid QR code data.";
    }
} else {
    echo "No data received.";
}
?>
