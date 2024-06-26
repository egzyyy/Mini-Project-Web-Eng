<?php
session_start();

// Start output buffering
ob_start();

include('../Layout/staff_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply-summon'])) {
    $plate_number = $_POST['plate_number'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $violation_type = $_POST['violation_type'];
    $demerit_points = 0;

    switch ($violation_type) {
        case 'Parking Violation':
            $demerit_points = 10;
            break;
        case 'Not Complying with Campus Traffic Regulations':
            $demerit_points = 15;
            break;
        case 'Accident Caused':
            $demerit_points = 20;
            break;
    }

    $sql = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE V_plateNum = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $plate_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vehicle_id = $row['V_vehicleID'];

        $sql = "SELECT * FROM trafficSummon WHERE V_vehicleID = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();
        $result_summon = $stmt->get_result();

        if ($result_summon->num_rows > 0) {
            $row_summon = $result_summon->fetch_assoc();
            $current_demerit_points = (int)$row_summon['TF_demeritPoint'];
            $new_demerit_points = $current_demerit_points + $demerit_points;

            $sql_update = "UPDATE trafficSummon SET TF_date = ?, TF_status = ?, TF_violationType = ?, TF_demeritPoint = ? WHERE V_vehicleID = ?";
            $stmt_update = $link->prepare($sql_update);
            $stmt_update->bind_param("sssii", $date, $status, $violation_type, $new_demerit_points, $vehicle_id);

            if ($stmt_update->execute()) {
                $_SESSION['summon'] = [
                    'plate_number' => $plate_number,
                    'date' => $date,
                    'status' => $status,
                    'violation_type' => $violation_type,
                    'demerit_points' => $new_demerit_points
                ];
                header("Location: qrCode.php");
                exit();
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error updating traffic summon: " . $link->error . "</div>";
            }

            $stmt_update->close();
        } else {
            $sql_insert = "INSERT INTO trafficSummon (V_vehicleID, TF_date, TF_status, TF_violationType, TF_demeritPoint) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $link->prepare($sql_insert);
            $stmt_insert->bind_param("isssi", $vehicle_id, $date, $status, $violation_type, $demerit_points);

            if ($stmt_insert->execute()) {
                $_SESSION['summon'] = [
                    'plate_number' => $plate_number,
                    'date' => $date,
                    'status' => $status,
                    'violation_type' => $violation_type,
                    'demerit_points' => $demerit_points
                ];
                header("Location: qrCode.php");
                exit();
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error adding traffic summon: " . $link->error . "</div>";
            }

            $stmt_insert->close();
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>No vehicle found with that plate number.</div>";
    }

    $stmt->close();
}

mysqli_close($link);

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Summon</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            color: #333; 
            line-height: 1.6; 
        }
        .content-container { 
            max-width: 800px; 
            margin: 50px auto; 
            margin-left: 280px; 
            padding: 20px; 
            background-color: white; 
            border-radius: 10px; 
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1); 
            text-align: center; 
        }
        .content-container h2 { 
            margin-bottom: 20px; 
        }
        form { 
            background: #fff; 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1); 
            margin-top: 20px; 
        }
        form label { 
            display: block; 
            margin-bottom: 10px; 
            font-weight: bold; 
        }
        .form-group { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 10px; 
        }
        .form-group label { 
            flex: 1; 
            text-align: left; 
            margin-right: 10px; 
        }
        .form-group input[type="text"], 
        .form-group input[type="date"], 
        .form-group select { 
            flex: 2; 
            width: calc(100% - 22px); 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            font-size: 16px; 
        }
        button { 
            display: inline-block; 
            padding: 12px 24px; 
            font-size: 16px; 
            color: #fff; 
            background-color: #800000; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            transition: background-color 0.3s; 
        }
        button:hover { 
            background-color: #575757; 
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Add Summon</h2>
        <form action="Module4/applySummon.php" method="post">
            <div class="form-group">
                <label for="plate_number">Plate Number:</label>
                <input type="text" id="plate_number" name="plate_number" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
            </div>
            <div class="form-group">
                <label for="violation_type">Violation Type:</label>
                <select id="violation_type" name="violation_type">
                    <option value="Parking Violation">Parking Violation</option>
                    <option value="Not Complying with Campus Traffic Regulations">Not Complying with Campus Traffic Regulations</option>
                    <option value="Accident Caused">Accident Caused</option>
                </select>
            </div>
            <button type="submit" name="apply-summon">Apply Summon</button>
        </form>
    </div>
</body>
</html>
