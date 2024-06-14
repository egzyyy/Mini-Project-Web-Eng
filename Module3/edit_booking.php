<?php
session_start();
include('../Layout/student_layout.php');
include('../phpqrcode/qrlib.php'); // Include QRcode library

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

$bookingID = isset($_GET['id']) ? $_GET['id'] : '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicleID = $_POST['vehicleID'];
    $startTime = $_POST['startTime'];
    $parkingSpaceID = $_POST['parkingSpaceID'];
    $bookingID = $_POST['bookingID'];

    $vehicleQuery = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum = ? AND STU_studentID = ?";
    $stmt = mysqli_prepare($link, $vehicleQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $plateNum, $studentID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $vehicle = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    } else {
        die('Error preparing statement: ' . $link->error);
    }

    if ($vehicle) {
        $vehicleID = $vehicle['V_vehicleID'];

        // Check for existing booking for the same parking space and overlapping time
        $endTime = date('Y-m-d H:i:s', strtotime($startTime . ' + 1 hour')); // Assuming 1 hour duration
        $clashError = '';

        // Check for existing booking for the same parking space and overlapping time
        $existingBookingQuery = "SELECT COUNT(*) AS count 
                                FROM booking 
                                WHERE P_parkingSpaceID = ? 
                                AND ((B_startTime <= ? AND B_endTime > ?) OR (B_startTime < ? AND B_endTime >= ?))";
        $stmt = mysqli_prepare($link, $existingBookingQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'issss', $parkingSpaceID, $startTime, $startTime, $endTime, $endTime);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($row['count'] > 0) {
                $clashError = "The selected time slot is already booked for this parking space. Please choose a different time.";
            }
        } else {
            die('Error preparing statement: ' . $link->error);
        }

        // Check if the vehicle is already booked for the same time slot
        $vehicleBookingQuery = "SELECT COUNT(*) AS count 
                                FROM booking 
                                WHERE V_vehicleID = ? 
                                AND ((B_startTime <= ? AND B_endTime > ?) OR (B_startTime < ? AND B_endTime >= ?))";
        $stmt = mysqli_prepare($link, $vehicleBookingQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'issss', $vehicleID, $startTime, $startTime, $endTime, $endTime);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($row['count'] > 0) {
                $clashError = "This vehicle is already booked for another time slot. Please choose a different vehicle or time.";
            }
        } else {
            die('Error preparing statement: ' . $link->error);
        }

        if (empty($clashError)) {     
            // Update booking information
            $updateQuery = "UPDATE booking SET B_startTime = ?, P_parkingSpaceID = ?, V_vehicleID = ? WHERE B_bookingID = ?";
            $stmt = mysqli_prepare($link, $updateQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'siii', $startTime, $parkingSpaceID, $vehicleID, $bookingID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                // Generate QR code for the updated booking
                $qrCodeDir = "../../QRImage";
                if (!is_dir($qrCodeDir)) {
                    mkdir($qrCodeDir, 0755, true);
                }
                $qrData = "Booking ID: $bookingID\nStart Time: $startTime\nVehicle ID: $vehicleID\nParking Space ID: $parkingSpaceID";
                $qrImagePath = "$qrCodeDir/booking{$bookingID}.png";
                QRcode::png($qrData, $qrImagePath, QR_ECLEVEL_L, 5);

                // Store booking ID and token in session for verification
                $_SESSION['bookingID'] = $bookingID;
                $_SESSION['enter_end_time_token'] = bin2hex(random_bytes(16));

                // Redirect to view booking page
                header('Location: view_booking.php');
                exit();
            } else {
                die('Error preparing statement: ' . mysqli_error($link));
            }
        } else {
            $clashError = "The selected time slot is not available. Please choose a different time or parking space.";
        }
        } else {
        $clashError = "Invalid vehicle selected.";
        }
        }

$booking = null;
if (!empty($bookingID)) {
    $query = "SELECT * FROM booking WHERE B_bookingID = ?";
    $stmt = mysqli_prepare($link, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $bookingID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $booking = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    } else {
        die('Error preparing statement: ' . mysqli_error($link));
    }
}

$vehicles = [];
$query = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE STU_studentID = ?";
$stmt = mysqli_prepare($link, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['STU_studentID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicles[] = $row;
    }
    mysqli_stmt_close($stmt);
}

$locations = [];
$query = "SELECT DISTINCT P_location FROM parkingSpace";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $locations[] = $row['P_location'];
}

$parkingSpaces = [];
$query = "SELECT P_parkingSpaceID, P_location FROM parkingSpace WHERE P_status = 'available'";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $parkingSpaces[$row['P_location']][] = $row;
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <script>
        function updateParkingSpaces() {
            const location = document.getElementById('location').value;
            const parkingSpaces = <?php echo json_encode($parkingSpaces); ?>;
            const parkingSpaceSelect = document.getElementById('parkingSpaceID');
            parkingSpaceSelect.innerHTML = '';

            if (parkingSpaces[location]) {
                parkingSpaces[location].forEach(space => {
                    const option = document.createElement('option');
                    option.value = space.P_parkingSpaceID;
                    option.textContent = space.P_parkingSpaceID;
                    parkingSpaceSelect.appendChild(option);
                });
            }
        }
    </script>
</head>
<body>
    <div class='content-container'>
    <?php if ($booking): ?>
        <form method="POST">
            <input type="hidden" name="bookingID" value="<?php echo htmlspecialchars($bookingID); ?>">
            <label for="vehicleID">Vehicle:</label>
            <select name="vehicleID" id="vehicleID" required>
                <?php foreach ($vehicles as $vehicle): ?>
                    <option value="<?php echo htmlspecialchars($vehicle['V_vehicleID']); ?>" <?php echo ($vehicle['V_vehicleID'] == $booking['V_vehicleID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($vehicle['V_plateNum']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="startTime">Start Time:</label>
            <input type="datetime-local" name="startTime" id="startTime" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($booking['B_startTime']))); ?>" required>
            <br>
            <label for="location">Location:</label>
            <select name="location" id="location" onchange="updateParkingSpaces()" required>
                <option value="">Select a location</option>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo htmlspecialchars($location); ?>"><?php echo htmlspecialchars($location); ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="parkingSpaceID">Parking Space:</label>
            <select name="parkingSpaceID" id="parkingSpaceID" required>
                <!-- Options will be populated based on location selection -->
            </select>
            <br>
            <button type="submit">Update Booking</button>
        </form>
    <?php else: ?>
        <p>Invalid booking ID.</p>
    <?php endif; ?>
    </div>
</body>
</html>

