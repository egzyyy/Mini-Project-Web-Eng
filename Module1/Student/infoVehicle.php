<?php
session_start();
require('../../Layout/student_layout.php');

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Perform inner join query to get student and vehicle details
$query = "SELECT student.STU_name, student.STU_email, vehicle.V_plateNum, vehicle.V_vehicleType, vehicle.V_status
          FROM vehicle
          INNER JOIN student ON vehicle.STU_studentID = student.STU_studentID";
$result = mysqli_query($link, $query);

if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error performing query: " . mysqli_error($link) . "</div>";
} else {
    ?>
    <div class="table-responsive">
        <table id="dataTable" style="margin-top: 50px; padding-right:0; padding-bottom: 20px; margin-left: 50px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">No</th>
                    <th style="border: 1px solid black; padding: 8px;">Name</th>
                    <th style="border: 1px solid black; padding: 8px;">Email</th>
                    <th style="border: 1px solid black; padding: 8px;">Plate Number</th>
                    <th style="border: 1px solid black; padding: 8px;">Vehicle Type</th>
                    <th style="border: 1px solid black; padding: 8px;">Status</th>
                    <th style="border: 1px solid black; padding: 8px;">QR</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cnt = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $STU_name = htmlspecialchars($row['STU_name']);
                    $STU_email = htmlspecialchars($row['STU_email']);
                    $V_plateNum = htmlspecialchars($row['V_plateNum']);
                    $V_vehicleType = htmlspecialchars($row['V_vehicleType']);
                    $V_status = htmlspecialchars($row['V_status']);
                    $qrData = "Name: $STU_name | Email: $STU_email | No plate: $V_plateNum | Type: $V_vehicleType";
                    $qrDataEncoded = urlencode($qrData);
                    ?>
                    <tr>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $cnt; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $STU_name; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $STU_email; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_plateNum; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_vehicleType; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_status; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;">

                            <?php if ($V_status == 'approved'): ?>
                                <img style="width:150%" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $qrDataEncoded; ?>" alt="QR Code">
                            <?php endif; ?>

                        </td>
                    </tr>
                    <?php
                    $cnt++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Close the database connection
mysqli_close($link);
?>

<style>
/* Add your styles here */
</style>
