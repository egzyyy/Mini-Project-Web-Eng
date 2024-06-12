<?php
// Include header file
// Start session and get student ID
session_start();
require('../../Layout/student_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}


$studentID = $_SESSION['STU_studentID']; 

// Fetch student details
$query = "SELECT * FROM student WHERE STU_studentID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<div class="main">
    <h1>Profile </h1>
    <div class="card">
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td><b>Name</b></td>
                        <td>:</td>
                        <td><?php echo $student['STU_name'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>:</td>
                        <td><?php echo $student['STU_email'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Phone Number</b></td>
                        <td>:</td>
                        <td><?php echo $student['STU_phoneNum'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>:</td>
                        <td><?php echo $student['STU_address'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Year of Study</b></td>
                        <td>:</td>
                        <td><?php echo $student['STU_yearStudy'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td>:</td>
                        <td><?php echo $student['STU_type'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>
                        <form action="editProfile.php">
                            <button type="submit" class="btn btn-edit">Edit</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$link->close();
?>
