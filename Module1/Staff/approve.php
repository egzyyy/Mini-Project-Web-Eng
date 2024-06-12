<?php
session_start();
require('../../Layout/staff_layout.php');

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
$query_pending = "SELECT * FROM vehicle WHERE V_status = 'pending'";
$stmt_pending = $link->prepare($query_pending);

if (!$stmt_pending) {
    echo "<div class='alert alert-danger' role='alert'>Error preparing the statement: " . $link->error . "</div>";
} else {
    // Execute the statement and get results
    $stmt_pending->execute();
    $result_pending = $stmt_pending->get_result();
    $cnt = 1;

    // Display pending vehicle registrations
    while ($row = $result_pending->fetch_object()) {
        ?>
        <!-- Your HTML table row code here -->
        <?php
        $cnt++;
    }

    // Close the statement
    $stmt_pending->close();
}

// Close the database connection
$link->close();
?>


<div class="table-responsive">
    <table id="dataTable" style="padding-top: 15px; padding-right:0; padding-bottom: 20px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Plate Number</th>
                <th>Vehicle Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM vehicle WHERE V_status = 'pending'";
            $stmt = $link->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $cnt = 1;
            while ($row = $result->fetch_object()) {
            ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row->STU_name; ?></td>
                    <td><?php echo $row->V_plateNum; ?></td>
                    <td><?php echo $row->V_vehicleType; ?></td>
                    <td><?php echo $row->V_status; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="vehicle_id" value="<?php echo $row->V_vehicleID; ?>">
                            <select name="approval_status">
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                            <button type="submit" name="approve" class="btn btn-success">Submit</button>
                        </form>
                    </td>
                </tr>
            <?php
                $cnt = $cnt + 1;
            }
            ?>
        </tbody>
    </table>
</div>


<style>
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

