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
    <style>
        
.btn-save {
    background-color: #3224f7;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.40rem;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
}

.btn-save:hover {
    background-color: #3983f2;
    border-color: #2d9af3;
}

.btn-save:active {
    background-color: #1689e7;
}
/* End */
    </style>
</head>
<body>
<div class="main">
<style>
        /* Import Font Dancing Script */

* {
    margin: 0;
}

/* NavbarTop */
.navbar-top {
    background-color: #fff;
    color: #333;
    box-shadow: 0px 4px 8px 0px grey;
    height: 70px;
}

.title {
    padding-top: 15px;
    position: absolute;
    left: 45%;
}


.icon-count {
    background-color: #ff0000;
    color: #fff;
    float: right;
    font-size: 11px;
    left: -25px;
    padding: 2px;
    position: relative;
}

/* End */

/* Sidenav */
.profile {
    margin-bottom: 20px;
    margin-top: -12px;
    text-align: center;
}

.profile img {
    border-radius: 50%;
    box-shadow: 0px 0px 5px 1px grey;
}

.name {
    font-size: 20px;
    font-weight: bold;
    padding-top: 20px;
}

.job {
    font-size: 16px;
    font-weight: bold;
    padding-top: 10px;
}

.url, hr {
    text-align: center;
}

.url hr {
    margin-left: 20%;
    width: 60%;
}

.url a {
    color: #818181;
    display: block;
    font-size: 20px;
    margin: 10px 0;
    padding: 6px 8px;
    text-decoration: none;
}

.url a:hover, .url .active {
    background-color: #e8f5ff;
    border-radius: 28px;
    color: #000;
    margin-left: 14%;
    width: 65%;
}

/* End */

/* Main */
.main {
    margin-top: 2%;
    font-size: 28px;
    padding: 0 10px;
    width: 58%;
}

.main h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

.main .card {
    background-color: #fff;
    border-radius: 18px;
    box-shadow: 1px 1px 8px 0 grey;
    height: auto;
    margin-bottom: 20px;
    padding: 20px 0 20px 50px;
}

.main .card table {
    border: none;
    font-size: 16px;
    height: 270px;
    width: 80%;
}

.edit {
    position: absolute;
    color: #e7e7e8;
    right: 14%;
}

.social-media {
    text-align: center;
    width: 90%;
}

.social-media span {
    margin: 0 10px;
}

.fa-facebook:hover {
    color: #4267b3 !important;
}

.fa-twitter:hover {
    color: #1da1f2 !important;
}

.fa-instagram:hover {
    color: #ce2b94 !important;
}

.fa-invision:hover {
    color: #f83263 !important;
}

.fa-github:hover {
    color: #161414 !important;
}

.fa-whatsapp:hover {
    color: #25d366 !important;
}

.fa-snapchat:hover {
    color: #fffb01 !important;
}

.btn-edit {
    background-color: #3224f7;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.40rem;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
}

.btn-edit:hover {
    background-color: #3983f2;
    border-color: #2d9af3;
}

.btn-edit:active {
    background-color: #1689e7;
}
/* End */
    </style>
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
