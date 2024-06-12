<?php
session_start();
// Include header file
require('../../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Start session and get student ID

$studentID = $_SESSION['STU_studentID']; 

// Fetch student details
$query = "SELECT * FROM student WHERE STU_studentID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $address = $_POST['address'];
    $yearStudy = $_POST['yearStudy'];
    $type = $_POST['type'];

    // Update student details
    $update_query = "UPDATE student SET STU_name = ?, STU_email = ?, STU_phoneNum = ?, STU_address = ?, STU_yearStudy = ?, STU_type = ? WHERE STU_studentID = ?";
    $stmt_update = $link->prepare($update_query);
    $stmt_update->bind_param("ssssisi", $name, $email, $phoneNum, $address, $yearStudy, $type, $studentID);

    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success' role='alert'>Profile updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating profile: " . $stmt_update->error . "</div>";
    }
    $stmt_update->close();
}

// Close the database connection
$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<div class="main">
    <h2>EDIT PROFILE</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="Profile.php">
                <table>
                    <tbody>
                        <tr>
                            <td><b>Name</b></td>
                            <td>:</td>
                            <td><input type="text" name="name" value="<?php echo $student['STU_name'] ?? ''; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>:</td>
                            <td><input type="email" name="email" value="<?php echo $student['STU_email'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Phone Number</b></td>
                            <td>:</td>
                            <td><input type="text" name="phoneNum" value="<?php echo $student['STU_phoneNum'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>:</td>
                            <td><input type="text" name="address" value="<?php echo $student['STU_address'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Year of Study</b></td>
                            <td>:</td>
                            <td><input type="number" name="yearStudy" value="<?php echo $student['STU_yearStudy'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Type</b></td>
                            <td>:</td>
                            <td><input type="text" name="type" value="<?php echo $student['STU_type'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <button class="btn btn-save" type="submit">Save</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>
