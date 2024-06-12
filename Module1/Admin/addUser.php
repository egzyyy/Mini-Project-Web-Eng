<?php
// Include header file
require('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Include database connection file
mysqli_select_db($link, "web_eng");

// Check if form is submitted and the add_user button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    // Get form data
    $username = $_POST['studentID'];
    $studentName = $_POST['studentName'];
    $studentType = $_POST['studentType'];
    $studentPhoneNum = $_POST['studentPhoneNum'];
    $studentYear = $_POST['studentYear'];
    $studentAddress = $_POST['studentAddress'];
    $studentEmail = $_POST['studentEmail'];

    // Default password value
    $defaultPassword = "FK123"; // You can change this default value

    // Prepare and execute the insert query for the student table
    $queryStudent = "INSERT INTO student (STU_username, STU_name, STU_type, STU_phoneNum, STU_yearStudy, STU_address, STU_email, STU_password)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmtStudent = $link->prepare($queryStudent);
$stmtStudent->bind_param("sssissss", $username, $studentName, $studentType, $studentPhoneNum, $studentYear, $studentAddress, $studentEmail, $defaultPassword);



    // Execute both queries in a transaction
    mysqli_autocommit($link, false);
    $success = true;

    if (!$stmtStudent->execute()) {
        $success = false;
        echo "<div class='alert alert-danger' role='alert'>Error adding student: " . $stmtStudent->error . "</div>";
    }

    if ($success) {
        mysqli_commit($link);
        echo "<div class='alert alert-success' role='alert'>New student added successfully!</div>";
    } else {
        mysqli_rollback($link);
    }

    // Close the statement
    $stmtStudent->close();
}

// Close the database connection
$link->close();
?>

<link rel="stylesheet" href="addUser.css">

<div class="card">
    <div class="card-header">
        User Registration
    </div>
    <div class="card-body">
        <!-- Add User Form -->
        <form method="POST">
            <div class="form-group mb-3">
                <label for="studentName">Full Name</label>
                <input type="text" required class="form-control" id="studentName" name="studentName">
            </div>
            <div class="form-group mb-3">
                <label for="studentID">Student ID</label>
                <input type="text" required class="form-control" id="studentID" name="studentID">
            </div>
            <div class="form-group mb-3">
                <label for="studentPhoneNum">Phone Number</label>
                <input type="tel" required class="form-control" id="studentPhoneNum" name="studentPhoneNum">
            </div>
            <div class="form-group mb-3">
                <label for="studentAddress">Address</label>
                <input type="text" required class="form-control" id="studentAddress" name="studentAddress">
            </div>
            <div class="form-group mb-3">
                <label for="studentYear">Year of Study</label>
                <input type="number" required class="form-control" id="studentYear" name="studentYear">
            </div>
            <div class="form-group mb-3">
                <label for="studentType">Level Of Study</label>
                <select class="form-control" required id="studentType" name="studentType">
                    <option value="Undergraduate">Undergraduate</option>
                    <option value="Postgraduate">Postgraduate</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="studentEmail">Email</label>
                <input type="email" required class="form-control" id="studentEmail" name="studentEmail">
            </div>
            <button type="submit" name="add_user" class="btn btn-success">Add User</button>
            <button type="reset" name="reset" class="btn btn-warning">Reset</button>
        </form>
        <!-- End Form -->
    </div>
</div>

<hr>

<?php
// Include footer and scripts
include('../../footer/footer.php');
?>







