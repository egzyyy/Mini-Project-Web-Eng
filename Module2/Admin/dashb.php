<?php include('../../Layout/admin_layout.php');
$link = new mysqli('localhost', 'root', '');

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Select the database
mysqli_select_db($link, "web_eng");

$result = $link->query("SELECT * FROM parkingSpace");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parking Management</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h1>Daily Available Parking Spaces</h1>
    <table>
        <tr>
            <th>Space Name</th>
            <th>Availability</th>
            <th>QR Code</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['space_name'] ?></td>
            <td><?= $row['is_available'] ? 'Available' : 'Occupied' ?></td>
            <td><img src="generate_qr.php?id=<?= $row['id'] ?>" alt="QR Code"></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
