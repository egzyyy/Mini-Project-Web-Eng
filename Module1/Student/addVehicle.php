<?php
// Include header file
session_start();
require('../../Layout/student_layout.php');

?>

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
    margin-left: 580px;
    width: fit-content;
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

<?php

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Check if form is submitted and the add_user button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    // Get form data
    $plateNum = $_POST['plate'];
    $vehicleType = $_POST['type'];
    $vehicleGrant = $_POST['grant'];
    $colour= $_POST['V_colour'];
    $brand = $_POST['V_brand'];


    // Get the STU_studentID from the session
    if (isset($_SESSION['STU_studentID'])) {
        $studentID = $_SESSION['STU_studentID'];

        // Prepare and execute the insert query
        $query = "INSERT INTO vehicle (V_plateNum, V_vehigrant, V_vehicleType, V_brand, V_colour, V_status, STU_studentID)
        VALUES (?, ?, ?, ?, ?, 'pending', ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param("sssssi", $plateNum, $vehigrant, $vehicleType, $brand, $colour, $studentID);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>Vehicle registered successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: User is not logged in.</div>";
    }
}

// Close the database connection
$link->close();
?>

<div class="card">
    <div class="card-header" style="margin-top:50px;">
        Vehicle Registration
    </div>
    <div class="card-body">
        <!-- Add User Form -->
        <form method="POST">
            <div class="form-group mb-3">
                <label for="plate">Plate Number</label>
                <input type="text" required class="form-control" id="plate" name="plate" required>
            </div>
            <div class="form-group mb-3">
                <label for="type">Type:</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="grant">Grant</label>
                <input type="file" class="form-control" id="grant" name="grant" required>
            </div>
            <div class="form-group mb-3">
                <label for="V_brand">Brand</label>
                <select class="form-control" required id="V_brand" name="V_brand">
                    <option value="Toyota">Toyota</option>
                    <option value="Honda">Honda</option>
                    <option value="Ford">Perodua</option>
                    <option value="Chevrolet">Proton</option>
                    <option value="Volkswagen">Volkswagen</option>
                    <option value="BMW">BMW</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="V_colour">Color</label>
                <select class="form-control" required id="V_colour" name="V_colour">
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Silver">Silver</option>
                    <option value="Gray">Gray</option>
                    <option value="Red">Red</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <button type="submit" name="add_user" class="btn btn-success">Register Vehicle</button>
            <button type="reset" name="reset" class="btn btn-warning">Reset</button>
        </form>
        <!-- End Form -->
    </div>
</div>


<?php
// Include footer and scripts
include('../../footer/footer.php');
?>
