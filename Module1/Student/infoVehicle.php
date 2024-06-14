<?php
session_start();
require('../../Layout/student_layout.php');

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Perform inner join query to get student and vehicle details
$query = "SELECT student.STU_name, student.STU_email, vehicle.V_plateNum, vehicle.V_vehicleType, vehicle.V_status, vehicle.V_brand, vehicle.V_colour
          FROM vehicle
          INNER JOIN student ON vehicle.STU_studentID = student.STU_studentID";
$result = mysqli_query($link, $query);

if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error performing query: " . mysqli_error($link) . "</div>";
} else {
    ?>
    <div class="table-responsive">
        <table id="dataTable" style="margin-top: 50px; padding-right:0; padding-bottom: 20px; margin-left: 100px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">No</th>
                    <th style="border: 1px solid black; padding: 8px;">Brand</th>
                    <th style="border: 1px solid black; padding: 8px;">Colour</th>
                    <th style="border: 1px solid black; padding: 8px;">Plate Number</th>
                    <th style="border: 1px solid black; padding: 8px;">Vehicle Type</th>
                    <th style="border: 1px solid black; padding: 8px;">Status</th>
                    <th style="border: 1px solid black; padding: 8px;">Action</th>
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
                    $V_brand = htmlspecialchars($row['V_brand']);
                    $V_colour = htmlspecialchars($row['V_colour']);
                    $qrData = "Name: $STU_name | Email: $STU_email | No plate: $V_plateNum | Type: $V_vehicleType | Brand: $V_brand | Colour: $V_colour";
                    $qrDataEncoded = urlencode($qrData);
                    ?>
                    <tr>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $cnt; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_brand; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_colour; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_plateNum; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_vehicleType; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_status; ?></td>
                        <td style="border: 1px solid black; padding: 20px 50px;">
                            <?php if ($V_status == 'approved'): ?>
                                <button type="button" onclick="showQrPopup('<?php echo $qrDataEncoded; ?>')">View QR</button>
                            <?php endif; ?>
                            <form method="post" action="Module1/student/deleteVehicle.php" style="display:inline;">
                                <input type="hidden" name="V_plateNum" value="<?php echo $V_plateNum; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</button>
                            </form>
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

<!-- QR Code Modal -->
<div id="qrModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeQrPopup()">&times;</span>
        <img id="qrCodeImage" src="" alt="QR Code">
    </div>
</div>

<style>
/* Add your styles here */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 15%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

<script>
function showQrPopup(data) {
    var modal = document.getElementById("qrModal");
    var img = document.getElementById("qrCodeImage");
    img.src = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" + data;
    modal.style.display = "block";
}

function closeQrPopup() {
    var modal = document.getElementById("qrModal");
    modal.style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    var modal = document.getElementById("qrModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
