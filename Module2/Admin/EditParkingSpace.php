<?php
include('../../Layout/admin_layout.php');
include('../../db.php'); // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['P_parkingSpaceID'])) {
    $parkingSpaceID = mysqli_real_escape_string($link, $_GET['P_parkingSpaceID']);
    
    // Fetch parking space information
    $result = mysqli_query($link, "SELECT * FROM parkingSpace WHERE P_parkingSpaceID = '$parkingSpaceID'");
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        echo "Error: Parking space not found.";
        exit;
    }
} else {
    echo "Error: Invalid request.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking Space</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .content-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css') no-repeat;
            background-position: right 10px top 50%;
            background-size: 20px;
            background-color: #fff;
            cursor: pointer;
        }
        button[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Edit Parking Space</h2>
        <form action="update_parking.php" method="post">
            <input type="hidden" name="parkingSpaceID" value="<?php echo $row['P_parkingSpaceID']; ?>">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo $row['P_location']; ?>" required>
            
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="available" <?php echo ($row['P_status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                <option value="occupied" <?php echo ($row['P_status'] == 'occupied') ? 'selected' : ''; ?>>Occupied</option>
            </select>
            
            <label for="type">Parking Type</label>
            <select id="type" name="type" required>
                <option value="staff" <?php echo ($row['P_parkingType'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                <option value="student" <?php echo ($row['P_parkingType'] == 'student') ? 'selected' : ''; ?>>Student</option>
            </select>
            
            <button type="submit">Update Parking Space</button>
        </form>
    </div>
</body>
</html>

