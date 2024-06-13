<?php
// Include the database connection file
include ('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $duration = mysqli_real_escape_string($link, $_POST['duration']);
    $qr_code = mysqli_real_escape_string($link, $_POST['qr_code']);

    // Insert parking information into the database
    $parking_sql = "INSERT INTO parking (qr_code, duration) VALUES ('$qr_code', '$duration')";
    if ($link->query($parking_sql) === TRUE) {
        echo "<h2>Parking Confirmation</h2>";
        echo "<p>Duration: $duration hours</p>";
        echo "<p>QR Code: $qr_code</p>";
    } else {
        echo "Error: " . $parking_sql . "<br>" . $link->error;
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Your Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        form {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin: 10px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .form-group button {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Park Your Car</h2>
        <form method="post" action="parking.php">
            <div class="form-group">
                <label for="qr_code">QR Code:</label>
                <input type="text" id="qr_code" name="qr_code" required>
            </div>
            <div class="form-group">
                <label for="duration">Expected Parking Duration (hours):</label>
                <input type="number" id="duration" name="duration" required>
            </div>
            <div class="form-group">
                <button type="submit">Confirm Parking</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
}
?>
