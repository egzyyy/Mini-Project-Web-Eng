<?php
session_start();

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if student is logged in
if (!isset($_SESSION['STU_studentID'])) {
    die('Student not logged in');
}

$studentID = $_SESSION['STU_studentID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingID = $_POST['bookingID'];
    $startTime = $_POST['startTime'];
    $V_vehicleID = $_POST['V_vehicleID']; // Corrected variable name
    $parkingSpaceID = $_POST['parkingSpaceID'];
    $P_location = $_POST['P_location'];

    // Check if the selected vehicle belongs to the student
    $vehicleQuery = "SELECT V_plateNum FROM vehicle WHERE V_vehicleID = ? AND STU_studentID = ?";
    $stmt = mysqli_prepare($link, $vehicleQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $V_vehicleID, $studentID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $vehicle = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$vehicle) {
            die('Selected vehicle does not belong to the student.');
        }
    } else {
        die('Error preparing statement: ' . mysqli_error($link));
    }

    // Check for existing booking for the same parking space and overlapping time
    $clashError = '';

    // Check if the parking space is already booked for the selected time
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
        die('Error preparing statement: ' . mysqli_error($link));
    }

    // Check if the vehicle is already booked for the same time slot
    if (empty($clashError)) {
        $vehicleBookingQuery = "SELECT COUNT(*) AS count 
                                FROM booking 
                                WHERE V_vehicleID = ? 
                                AND (? < B_endTime AND ? > B_startTime)";
        $stmt = mysqli_prepare($link, $vehicleBookingQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iss', $V_vehicleID, $startTime, $startTime);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($row['count'] > 0) {
                $clashError = "This vehicle is already booked for another time slot. Please choose a different vehicle or time.";
            }
        } else {
            die('Error preparing statement: ' . mysqli_error($link));
        }
    }

    // If no clash errors, proceed with the update
    if (empty($clashError)) {
        // Update the booking details
        $updateQuery = "UPDATE booking b
                        JOIN parkingSpace p ON b.P_parkingSpaceID = p.P_parkingSpaceID
                        SET b.B_startTime = ?, b.V_vehicleID = ?, b.P_parkingSpaceID = ?, p.P_location = ?
                        WHERE b.B_bookingID = ? AND b.V_vehicleID = ?";
        $stmt = mysqli_prepare($link, $updateQuery);
        
        mysqli_stmt_bind_param($stmt, 'sisiii', $startTime, $V_vehicleID, $parkingSpaceID, $P_location, $bookingID, $V_vehicleID);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Booking details updated successfully');</script>";
            echo "<script>window.location.replace('view_booking.php');</script>";
            
            // Store booking ID 
            $_SESSION['bookingID'] = $bookingID;
            
            // Redirect to view_booking.php with the token
            header("Location: generate_qr_.php?bookingID=" . $bookingID);
            exit(); // Stop further execution after redirection
        } else {
            echo "<script>alert('Error updating booking details: " . mysqli_stmt_error($stmt) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('$clashError');</script>";
    }
}

mysqli_close($link);
?>
