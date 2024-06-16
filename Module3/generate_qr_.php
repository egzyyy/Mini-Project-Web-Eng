<?php
require '../phpqrcode/qrlib.php';

if (isset($_GET['bookingID'])) {
    $bookingID = $_GET['bookingID'];
    
    // Create the URL for the QR code
    $qrUrl = 'http://localhost/projectWeb/Mini-Project-Web-Eng/Module3/view_bookingpage.php?bookingID=' . urlencode($bookingID);

    // Path where the QR code image will be saved
    $filePath = "QRImage/booking{$bookingID}.png";

    // Generate the QR code
    QRcode::png($qrUrl, $filePath);

    // Redirect to view_booking.php to display the QR code
    header("Location: view_booking.php");
} else {
    die('Booking ID not specified');
}
?>