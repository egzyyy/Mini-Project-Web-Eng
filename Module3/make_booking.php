<?php
session_start();
include('../Layout/student_layout.php');

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    die('User not logged in');
}

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Assume user ID is stored in session
$userID = $_SESSION['userID'];

// Fetch user's vehicles
$sql = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE STU_studentID = ?";
$stmt = $link->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die('Error preparing statement: ' . $link->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicleID = $_POST['vehicleID'];
    $startTime = $_POST['startTime'];
    $parkingSpaceID = $_POST['parkingSpaceID'];

    // Insert booking with only start time
    $query = "INSERT INTO booking (B_startTime, P_parkingSpaceID, V_vehicleID) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssi', $startTime, $parkingSpaceID, $vehicleID);
        mysqli_stmt_execute($stmt);
        $bookingID = mysqli_insert_id($link); // Get the inserted booking ID
        mysqli_stmt_close($stmt);

        // Generate QR code URL
        $qrUrl = "http://yourdomain.com/complete_booking.php?bookingID=" . $bookingID;

        // You need a library to generate QR codes, e.g., PHP QR Code
        // Include the library and generate the QR code image
        include('phpqrcode/qrlib.php');
        $qrImagePath = 'qrcodes/' . $bookingID . '.png';
        QRcode::png($qrUrl, $qrImagePath);

        header("Location: view_bookings.php");
        exit();
    } else {
        die('Error preparing statement: ' . $link->error);
    }
}

$parkingSpaceID = isset($_GET['id']) ? $_GET['id'] : '';
$query = "SELECT P_location, P_status, P_parkingType FROM parkingSpace WHERE P_parkingSpaceID = ?";
$stmt = mysqli_prepare($link, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $parkingSpaceID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $parkingSpace = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    die('Error preparing statement: ' . $link->error);
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Make Booking</title>
</head>
<body>
    <div class=content-container>
    <h1>Booking for Parking Space: <?php echo htmlspecialchars($parkingSpaceID); ?></h1>
    <?php if ($parkingSpace): ?>
        <p>Location: <?php echo htmlspecialchars($parkingSpace['P_location']); ?></p>
        <p>Status: <?php echo htmlspecialchars($parkingSpace['P_status']); ?></p>
        <p>Type: <?php echo htmlspecialchars($parkingSpace['P_parkingType']); ?></p>
    <?php else: ?>
        <p>No details found for the specified parking space.</p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="parkingSpaceID" value="<?php echo htmlspecialchars($parkingSpaceID); ?>">
        <label for="vehicleID">Vehicle Number Plate:</label>
        <select name="vehicleID" id="vehicleID" required>
            <?php foreach ($vehicles as $vehicle): ?>
                <option value="<?php echo htmlspecialchars($vehicle['V_vehicleID']); ?>">
                    <?php echo htmlspecialchars($vehicle['V_plateNum']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="startTime">Start Time:</label>
        <input type="datetime-local" id="startTime" name="startTime" required>
        <br>
        <button type="submit">Book Now</button>
    </form>
    <?php if (isset($qrImagePath)): ?>
        <h2>Scan this QR code to complete your booking</h2>
        <img src="<?php echo $qrImagePath; ?>" alt="QR Code">
    <?php endif; ?>
    </div>
</body>
</html>
