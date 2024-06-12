<?php
session_start();
require('../../Layout/student_layout.php');

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if form is submitted and the approve button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $vehicleID = $_POST['vehicle_id'];
    $approvalStatus = $_POST['approval_status']; // This can be 'approved' or 'rejected'

    // Prepare the query to update vehicle registration status
    $query = "UPDATE vehicle SET V_status = ? WHERE V_vehicleID = ?";
    $stmt = $link->prepare($query);

    if (!$stmt) {
        echo "<div class='alert alert-danger' role='alert'>Error preparing the statement: " . $link->error . "</div>";
    } else {
        // Bind parameters and execute the statement
        $stmt->bind_param("si", $approvalStatus, $vehicleID);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>Vehicle registration status updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating status: " . $stmt->error . "</div>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Select pending vehicle registrations
$query_pending = "SELECT * FROM vehicle ";
$stmt_pending = $link->prepare($query_pending);

if (!$stmt_pending) {
    echo "<div class='alert alert-danger' role='alert'>Error preparing the statement: " . $link->error . "</div>";
} else {
    // Execute the statement and get results
    $stmt_pending->execute();
    $result_pending = $stmt_pending->get_result();
    $cnt = 1;

    if ($result_pending->num_rows > 0) {

    // Display pending vehicle registrations
    while ($row = $result_pending->fetch_object()) {
        // Initialize variables with empty values if $row is null
        $STU_name = '';
        $V_plateNum = '';
        $V_vehicleType = '';
        $V_status = '';

        // Check if $row is not null before accessing its properties
        if ($row) {
            $STU_studentID = $row->STU_studentID;
            $V_plateNum = $row->V_plateNum;
            $V_vehicleType = $row->V_vehicleType;
            $V_status = $row->V_status;
        }

        // Display table row with data or empty values
        ?>
        <div class="table-responsive">
    <table id="dataTable" style="margin-top: 50px; padding-right:0; padding-bottom: 20px; margin-left: 300px; border-collapse: collapse;">
        <thead>
            <tr>
            <th style="border: 1px solid black; padding: 8px;">No</th>
            <th style="border: 1px solid black; padding: 8px;">Name</th>
            <th style="border: 1px solid black; padding: 8px;">Plate Number</th>
            <th style="border: 1px solid black; padding: 8px;">Vehicle Type</th>
            <th style="border: 1px solid black; padding: 8px;">Status</th>
            <th style="border: 1px solid black; padding: 8px;">QR</th>
        </tr>
    </thead>
    <tbody>
        <!-- Table rows will be filled dynamically above -->
        <tr>
            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $cnt; ?></td>
            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $STU_studentID; ?></td>
            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_plateNum; ?></td>
            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_vehicleType; ?></td>
            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_status; ?></td>
            <td style="border: 1px solid black; padding: 20px 50px;">

            </td>
        </tr>
        </table>
        </div>
        <?php
        $cnt++;    
        
    }
    }
    else {
        echo '<div class="alert" role="alert">No Vehicle Proposal</div>';
    }
    // Close the statement
    $stmt_pending->close();
}

// Close the database connection
$link->close();
?>




<style>

.alert{
    margin-top: 200px;
    margin-left: 500px;
    width: 500px;
    text-align: center;
    background-color: cyan;
    border: solid;
    border-radius: 15px;
}
/* Card styling */
.card {
    border-radius: 0.25rem;
    width: 100%;
    max-width: 600px;
    padding-left: 30%;
}

.card-header {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    padding: 1rem;
    border-bottom: 1px solid #ddd;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    text-align: center;
}

/* Card body styling */
.card-body {
    padding: 2rem;
    width: auto;
    height: auto;
    padding-bottom: auto;
}

/* Form styling */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #ddd;
    border-radius: 0.25rem;
    padding: 0.5rem;
    width: 100%;
    box-sizing: border-box;
}

/* Button styling */
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.btn-warning {
    background-color: #f0ad4e;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-warning:hover {
    background-color: #ec971f;
    border-color: #ec971f;
}

.btn-warning:active {
    background-color: #d58512;
}

/* Styling for success message */
.alert-success {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    border-radius: 0.25rem;
}

/* Styling for error message */
.alert-danger {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    border-radius: 0.25rem;
}
</style>

