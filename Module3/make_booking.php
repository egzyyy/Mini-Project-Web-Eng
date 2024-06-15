<?php
ob_start(); // Start output buffering
session_start();
include('../Layout/student_layout.php');


$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if student is logged in
if (!isset($_SESSION['STU_studentID'])) {
    die('Student not logged in');
}

// Fetch student's vehicles using student ID
$studentID = $_SESSION['STU_studentID'];
$sql = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE STU_studentID = ?";
$stmt = $link->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die('Error preparing statement: ' . $link->error);
}

$parkingSpaceID = isset($_GET['id']) ? $_GET['id'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$parkingType = isset($_GET['type']) ? $_GET['type'] : '';


// Debugging: Print the received values
error_log("Received P_parkingSpaceID: " . $parkingSpaceID);
error_log("Received location: " . $location);
error_log("Received status: " . $status);
error_log("Received type: " . $parkingType);

// Check if the student already has an active booking
$activeBookingQuery = "SELECT COUNT(*) AS activeBookings FROM booking 
                       WHERE V_vehicleID IN (SELECT V_vehicleID FROM vehicle WHERE STU_studentID = ?) 
                       AND B_endTime IS NULL";
$stmt = $link->prepare($activeBookingQuery);
if ($stmt) {
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $activeBookingCount = $result->fetch_assoc()['activeBookings'];
    $stmt->close();
} else {
    die('Error preparing statement: ' . $link->error);
}

if ($activeBookingCount > 0) {
    die('You have an active booking. Please complete your current booking before making a new one.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plateNum = $_POST['plateNum'];
    $startTime = $_POST['startTime'];
    $parkingSpaceID = $_POST['parkingSpaceID'];

    // Check if the selected vehicle belongs to the student
    $vehicleQuery = "SELECT V_vehicleID FROM vehicle WHERE V_plateNum = ? AND STU_studentID = ?";
    $stmt = mysqli_prepare($link, $vehicleQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $plateNum, $studentID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        // Fetch the vehicle details
        if ($vehicle = mysqli_fetch_assoc($result)) {
            $vehicleID = $vehicle['V_vehicleID'];

            // Check for existing booking for the same parking space and overlapping time
            $clashError = '';

            // Check for existing booking for the same parking space and overlapping time
            $existingBookingQuery = "SELECT COUNT(*) AS count 
                                     FROM booking 
                                     WHERE P_parkingSpaceID = ? 
                                     AND ((? <= B_endTime AND ? > B_startTime) OR (? < B_endTime AND ? >= B_startTime))";
            $stmt = mysqli_prepare($link, $existingBookingQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'issss', $parkingSpaceID, $startTime, $startTime, $startTime, $startTime);
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
                                    AND (? < B_endTime AND ? > B_startTime)";
            $stmt = mysqli_prepare($link, $vehicleBookingQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'iss', $vehicleID, $startTime, $startTime);
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
                // Proceed with booking insertion
                $insertQuery = "INSERT INTO booking (B_startTime, P_parkingSpaceID, V_vehicleID) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($link, $insertQuery);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ssi', $startTime, $parkingSpaceID, $vehicleID);
                    mysqli_stmt_execute($stmt);
                    $bookingID = mysqli_insert_id($link);
                    mysqli_stmt_close($stmt);

                    // Store booking ID 
                    $_SESSION['bookingID'] = $bookingID;
                  
                    // Redirect to view_booking.php with the token
                     header("Location: generate_qr_.php?bookingID=" . $bookingID);
                    exit(); // Stop further execution after redirection
                } else {
                    die('Error preparing statement: ' . $link->error);
                }
            } else {
                echo "<script>alert('" . $clashError . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid vehicle selected.');</script>";
        }
    } else {
        die('Error preparing statement: ' . $link->error);
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make Booking</title>
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var now = new Date();
            var offset = now.getTimezoneOffset();
            now.setMinutes(now.getMinutes() - offset);
            var formattedDateTime = now.toISOString().slice(0, 16);
            document.getElementById('startTime').min = formattedDateTime;
        });
    </script>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <title>Make Booking</title>
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var now = new Date();
            var offset = now.getTimezoneOffset();
            now.setMinutes(now.getMinutes() - offset);
            var formattedDateTime = now.toISOString().slice(0, 16);
            document.getElementById('startTime').min = formattedDateTime;
        });
    </script>
</head>
<body>
<div class="content-container">
    <h1>Booking for Parking Space: <?php echo htmlspecialchars($parkingSpaceID); ?></h1>
    <p>Location: <?php echo htmlspecialchars($location); ?></p>
    <p>Status: <?php echo htmlspecialchars($status); ?></p>
    <p>Type: <?php echo htmlspecialchars($parkingType); ?></p>
   
    <form method="POST" action="module3/make_booking.php">
        <input type="hidden" name="parkingSpaceID" value="<?php echo htmlspecialchars($parkingSpaceID); ?>">
        <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
        <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">
        <input type="hidden" name="parkingType" value="<?php echo htmlspecialchars($parkingType); ?>">

        <label for="plateNum">Vehicle Number Plate:</label>
        <select name="plateNum" id="plateNum" required>
            <?php foreach ($vehicles as $vehicle): ?>
                <option value="<?php echo htmlspecialchars($vehicle['V_plateNum']); ?>">
                    <?php echo htmlspecialchars($vehicle['V_plateNum']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="startTime">Start Time:</label>
        <input type="datetime-local" id="startTime" name="startTime" required>
        <br>

        <button type="submit">Book</button>
    </form>
</div>
</body>
</html>
