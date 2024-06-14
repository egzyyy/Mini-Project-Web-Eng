<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h1>My Bookings</h1>
        <?php if (empty($bookings)): ?>
            <p>No bookings found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Start Time</th>
                        <th>Parking Location</th>
                        <th>Parking Type</th>
                        <th>Vehicle Plate Number</th>
                        <th>QR Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['B_bookingID']); ?></td>
                            <td><?php echo htmlspecialchars($booking['B_startTime']); ?></td>
                            <td><?php echo htmlspecialchars($booking['P_location']); ?></td>
                            <td><?php echo htmlspecialchars($booking['P_parkingType']); ?></td>
                            <td><?php echo htmlspecialchars($booking['V_plateNum']); ?></td>
                            <td>
                                <?php
                                $qrImagePath = "../../QRImage/booking{$booking['B_bookingID']}.png";
                                if (file_exists($qrImagePath)) {
                                    echo '<img src="' . $qrImagePath . '" alt="QR Code" style="width: 100px;">';
                                } else {
                                    echo '<a href="generate_qr.php?id=' . urlencode($booking['B_bookingID']) . '" class="button">Generate QR</a>';
                                }
                                ?>
                            </td>
                            <td><a href="cancel_booking.php?id=<?php echo urlencode($booking['B_bookingID']); ?>" class="button">Cancel</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="make_booking.php" class="button">Make New Booking</a>
    </div>
</body>
</html>
