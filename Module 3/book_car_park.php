<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $car_park_id = $_POST['car_park_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check for clashing
    $sql = "SELECT * FROM bookings WHERE car_park_id='$car_park_id' AND ('$start_time' < end_time AND '$end_time' > start_time)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='container'><p>Booking clash detected. <a href='index.php'>Go back</a></p></div>";
    } else {
        // Insert booking
        $qr_code = generateQRCode($user_id, $car_park_id, $start_time, $end_time);
        $sql = "INSERT INTO bookings (user_id, car_park_id, start_time, end_time, status, qr_code) 
                VALUES ('$user_id', '$car_park_id', '$start_time', '$end_time', 'confirmed', '$qr_code')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div class='container'><p>Booking successful. <br> QR Code: $qr_code <br> <a href='index.php'>Go back</a></p></div>";
        } else {
            echo "<div class='container'><p>Error: " . $sql . "<br>" . $conn->error . "</p></div>";
        }
    }
}

function generateQRCode($user_id, $car_park_id, $start_time, $end_time) {
    // Dummy QR code generation for demonstration purposes
    return "QR_" . md5($user_id . $car_park_id . $start_time . $end_time);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
            border-radius: 8px;
        }
        p {
            text-align: center;
        }
        a {
            color: #5cb85c;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Booking result will be displayed here -->
    </div>
</body>
</html>
<?php
$conn->close();
?>
