<?php
// Include header file
require('../../Layout/admin_layout.php');

// Include database connection file
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Initialize variables
$updateMessage = '';

// Handle update request
if (isset($_POST['submit'])) {
    $name = $_POST['studentName'];
    $phoneNum = $_POST['studentPhoneNum'];
    $email = $_POST['studentEmail'];
    $address = $_POST['studentAddress'];
    $type = $_POST['studentType'];
    $yearStudy = $_POST['studentYear'];
    $studentID = $_POST['studentID'];

    // Update query
    $updateQuery = "UPDATE student SET STU_name=?, STU_phoneNum=?, STU_email=?, STU_address=?, STU_type=?, STU_yearStudy=? WHERE STU_studentID=?";
    $stmt = $link->prepare($updateQuery);
    $stmt->bind_param("ssssssi", $name, $phoneNum, $email, $address, $type, $yearStudy, $studentID);
    
    if ($stmt->execute()) {
        $updateMessage = "<div class='alert alert-success' role='alert'>User updated successfully!</div>";
    } else {
        $updateMessage = "<div class='alert alert-danger' role='alert'>Error updating user: " . $stmt->error . "</div>";
    }
    
    // Close the statement
    $stmt->close();
}

// Fetch user details for editing
if (isset($_GET['u_id'])) {
    $userID = $_GET['u_id'];
    $fetchQuery = "SELECT * FROM student WHERE STU_studentID = ?";
    $stmt = $link->prepare($fetchQuery);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<link rel="stylesheet" href="addUser.css">

<div class="card">
    <div class="card-header">
        User Registration
    </div>
    <div class="card-body">
        <?php echo $updateMessage; ?>
        <!-- Add User Form -->
        <form method="POST">
            <div class="form-group mb-3">
                <label for="studentName">Full Name</label>
                <input type="text" class="form-control" id="studentName" name="studentName" value="<?php echo htmlspecialchars($user['STU_name']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="studentID">Student ID</label>
                <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo htmlspecialchars($user['STU_studentID']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="studentPhoneNum">Phone Number</label>
                <input type="tel" class="form-control" id="studentPhoneNum" name="studentPhoneNum" value="<?php echo htmlspecialchars($user['STU_phoneNum']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="studentAddress">Address</label>
                <input type="text" class="form-control" id="studentAddress" name="studentAddress" value="<?php echo htmlspecialchars($user['STU_address']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="studentType">Level Of Study</label>
                <select class="form-control" id="studentType" name="studentType" required>
                    <option value="Undergraduate" <?php echo $user['STU_type'] == 'Undergraduate' ? 'selected' : ''; ?>>Undergraduate</option>
                    <option value="Postgraduate" <?php echo $user['STU_type'] == 'Postgraduate' ? 'selected' : ''; ?>>Postgraduate</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="studentYear">Year Of Study</label>
                <input type="number" class="form-control" id="studentYear" name="studentYear" value="<?php echo htmlspecialchars($user['STU_yearStudy']); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="studentEmail">Email</label>
                <input type="email" class="form-control" id="studentEmail" name="studentEmail" value="<?php echo htmlspecialchars($user['STU_email']); ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Update User</button>
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
