<?php
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

$studentID = $_SESSION['STU_studentID'];

// Fetch student's bookings
$sql = "SELECT b.B_bookingID, b.B_startTime, b.B_endTime, p.P_parkingSpaceID, p.P_location, p.P_status, p.P_parkingType, v.V_vehicleID, v.V_plateNum
        FROM booking b
        JOIN parkingSpace p ON b.P_parkingSpaceID = p.P_parkingSpaceID
        JOIN vehicle v ON b.V_vehicleID = v.V_vehicleID
        WHERE v.STU_studentID = ? AND b.B_endTime IS NULL";
$stmt = $link->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die('Error preparing statement: ' . $link->error);
}

// Fetch distinct parking locations
$locations = [];
$sqlLocations = "SELECT DISTINCT P_location FROM parkingSpace ORDER BY P_location";
$resultLocations = mysqli_query($link, $sqlLocations);
if ($resultLocations) {
    while ($row = mysqli_fetch_assoc($resultLocations)) {
        $locations[] = $row['P_location'];
    }
} else {
    die('Error fetching parking locations: ' . mysqli_error($link));
}

// Fetch all parking spaces grouped by location
$dropdownOptions = [];
foreach ($locations as $location) {
    $sqlSpaces = "SELECT P_parkingSpaceID FROM parkingSpace WHERE P_location = ?";
    $stmtSpaces = $link->prepare($sqlSpaces);
    if ($stmtSpaces) {
        $stmtSpaces->bind_param("s", $location);
        $stmtSpaces->execute();
        $resultSpaces = $stmtSpaces->get_result();
        $dropdownOptions[$location] = [];
        while ($row = $resultSpaces->fetch_assoc()) {
            $dropdownOptions[$location][] = $row['P_parkingSpaceID'];
        }
        $stmtSpaces->close();
    } else {
        die('Error preparing statement: ' . $link->error);
    }
}

// Fetch registered vehicle plate numbers for the logged-in student
$vehicleOptions = [];
$sqlVehicles = "SELECT V_vehicleID, V_plateNum FROM vehicle WHERE STU_studentID = ?";
$stmtVehicles = $link->prepare($sqlVehicles);
if ($stmtVehicles) {
    $stmtVehicles->bind_param("i", $studentID);
    $stmtVehicles->execute();
    $resultVehicles = $stmtVehicles->get_result();
    while ($row = $resultVehicles->fetch_assoc()) {
        $vehicleOptions[] = $row;
    }
    $stmtVehicles->close();
} else {
    die('Error preparing statement: ' . $link->error);
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
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
        .location-section {
            display: none; /* Hide all location-specific sections initially */
        }
    </style>
    <script>
        function showParkingSpaces(location) {
            // Hide all location-specific sections
            var locationSections = document.querySelectorAll('.location-section');
            locationSections.forEach(function(section) {
                section.style.display = 'none';
            });

            // Show selected location section
            var selectedSection = document.getElementById('location-' + location);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }

        window.onload = function () {
            var locationSelect = document.getElementById("location");
            locationSelect.addEventListener("change", function () {
                var selectedLocation = this.value;
                showParkingSpaces(selectedLocation);
            });

            // Trigger initial display based on selected location
            var initialLocation = locationSelect.value;
            showParkingSpaces(initialLocation);
        };
        
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
    <h1>Edit Booking</h1>
    <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $booking): ?>
            <form method="POST" action="module3/update.php"> <!-- Changed action to update.php -->
                <p>Booking ID: <?php echo htmlspecialchars($booking['B_bookingID']); ?></p>
                <p>Location:
                    <select id="location" name="P_location" required>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?php echo htmlspecialchars($location); ?>" <?php if ($booking['P_location'] == $location) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($location); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>Status: <?php echo htmlspecialchars($booking['P_status']); ?></p>
                <p>Type: <?php echo htmlspecialchars($booking['P_parkingType']); ?></p>
                <p>Start Time: <?php echo htmlspecialchars($booking['B_startTime']); ?></p>
                <label for="startTime">New Start Time:</label>
                <input type="datetime-local" id="startTime" name="startTime" value="<?php echo date('Y-m-d\TH:i', strtotime($booking['B_startTime'])); ?>" required>
                <br>
                <label for="V_vehicleID">Select Vehicle Plate Number:</label>
                <select id="V_vehicleID" name="V_vehicleID" required>
                    <?php foreach ($vehicleOptions as $option): ?>
                        <option value="<?php echo htmlspecialchars($option['V_vehicleID']); ?>" <?php if ($booking['V_vehicleID'] == $option['V_vehicleID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($option['V_plateNum']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

                <!-- Hidden sections for parking spaces based on location -->
                <?php foreach ($locations as $location): ?>
                    <div id="location-<?php echo htmlspecialchars($location); ?>" class="location-section">
                        <label for="parkingSpaceID">New Parking Space:</label>
                        <select name="parkingSpaceID" required>
                            <?php foreach ($dropdownOptions[$location] as $option): ?>
                                <option value="<?php echo htmlspecialchars($option); ?>" <?php if ($booking['P_parkingSpaceID'] == $option) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($option); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
                
                <input type="hidden" name="bookingID" value="<?php echo htmlspecialchars($booking['B_bookingID']); ?>">
                <button type="submit">Update Booking</button>
            </form>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No active bookings found.</p>
    <?php endif; ?>
</div>
</body>
</html>
