<?php
require '../phpqrcode/qrlib.php';

if (isset($_GET['bookingID'])) {
    $bookingID = $_GET['bookingID'];
    
    // Fetch the booking details from the database
    $link = mysqli_connect("localhost", "root", "", "web_eng");
    if (!$link) {
        die('Error connecting to the server: ' . mysqli_connect_error());
    }

    $sql = "SELECT b.B_bookingID, b.V_vehicleID, b.B_startTime, b.P_parkingSpaceID, v.V_plateNum, p.P_location, p.P_status, p.P_parkingType
            FROM booking b
            JOIN vehicle v ON b.V_vehicleID = v.V_vehicleID
            JOIN parkingSpace p ON b.P_parkingSpaceID = p.P_parkingSpaceID
            WHERE b.B_bookingID = ?";
            
    $stmt = $link->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $bookingID);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();
    } else {
        die('Error preparing statement: ' . $link->error);
    }
    
    mysqli_close($link);

    // Prepare the QR code text
    $qrText = json_encode($booking);

    // Path where the QR code image will be saved
    $filePath = "QRImage/booking{$bookingID}.png";

    // Generate the QR code
    QRcode::png($qrText, $filePath);

    // Redirect to view_booking.php to display the QR code
    header("Location: view_booking.php");
} else {
    die('Booking ID not specified');
}
?>