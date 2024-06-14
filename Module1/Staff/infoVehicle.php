<?php
session_start();
require('../../Layout/staff_layout.php');

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Get the current date
$currentDate = date('Y-m-d');

// Check if form is submitted and the delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $vehicleID = $_POST['vehicle_id'];

    // Prepare the query to delete the vehicle
    $query = "DELETE FROM vehicle WHERE V_vehicleID = ?";
    $stmt = $link->prepare($query);

    if (!$stmt) {
        echo "<div class='alert alert-danger' role='alert'>Error preparing the statement: " . $link->error . "</div>";
    } else {
        // Bind parameters and execute the statement
        $stmt->bind_param("i", $vehicleID);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>Vehicle deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error deleting vehicle: " . $stmt->error . "</div>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Select all vehicle registrations
$query_all = "SELECT * FROM vehicle";
$stmt_all = $link->prepare($query_all);

if (!$stmt_all) {
    echo "<div class='alert alert-danger' role='alert'>Error preparing the statement: " . $link->error . "</div>";
} else {
    // Execute the statement and get results
    $stmt_all->execute();
    $result_all = $stmt_all->get_result();
    $cnt = 1;
    ?>
    <style>
    .alert {
        margin-top: 0px;
        width: 500px;
        text-align: center;
        background-color: cyan;
        border: solid;
        border-radius: 15px;
    }

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

    .card-body {
        padding: 2rem;
        width: auto;
        height: auto;
        padding-bottom: auto;
    }

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

    .alert-success {
        margin-left: 580px;
        width: fit-content;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        border-radius: 0.25rem;
    }

    .alert-danger {
        margin-bottom: 10px;
        padding: 10px;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        border-radius: 0.25rem;
    }
    </style>

    <div class="table-responsive">

    <div style="margin-top: 20px; text-align: center;">
        <center>
    <h2><b>Approved Vehicle</b></h2>
    </center>
            <h4>Date: <?php echo $currentDate; ?></h4>
        </div>
        <table id="dataTable" style="margin-top: 50px; padding-right: 0; padding-bottom: 20px; margin-left: 200px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">No</th>
                    <th style="border: 1px solid black; padding: 8px;">Brand</th>
                    <th style="border: 1px solid black; padding: 8px;">Colour</th>
                    <th style="border: 1px solid black; padding: 8px;">Plate Number</th>
                    <th style="border: 1px solid black; padding: 8px;">Vehicle Type</th>
                    <th style="border: 1px solid black; padding: 8px;">Status</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_all->num_rows > 0) {
                    while ($row = $result_all->fetch_object()) {
                        $V_brand = htmlspecialchars($row->V_brand);
                        $V_plateNum = htmlspecialchars($row->V_plateNum);
                        $V_vehicleType = htmlspecialchars($row->V_vehicleType);
                        $V_status = htmlspecialchars($row->V_status);
                        $V_colour = htmlspecialchars($row->V_colour);
                        $V_vehicleID = htmlspecialchars($row->V_vehicleID);
                        ?>
                        <tr>
                            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $cnt; ?></td>
                            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_brand; ?></td>
                            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_colour; ?></td>
                            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_plateNum; ?></td>
                            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_vehicleType; ?></td>
                            <td style="border: 1px solid black; padding: 20px 50px;"><?php echo $V_status; ?></td>

                        </tr>
                        <?php
                        $cnt++;
                    }
                } else {
                    echo '<tr><td colspan="7" style="border: 1px solid black; padding: 20px 50px;"><div class="alert alert-info" role="alert">No vehicles found</div></td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    // Close the statement
    $stmt_all->close();
}

// Close the database connection
$link->close();
?>
