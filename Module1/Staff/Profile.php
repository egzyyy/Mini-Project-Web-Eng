<?php
// Include header file
// Start session and get staff ID
session_start();
require('../Layout/staff_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

$staffID = $_SESSION['S_staffID'];

// Fetch staff details
$query = "SELECT * FROM staff WHERE S_staffID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();
?>
<body>
<link rel="stylesheet" href="profile.css">
<div class="main">
    <h1>Profile</h1>
    <div class="card">
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td><b>Name</b></td>
                        <td>:</td>
                        <td><?php echo $staff['S_name'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>:</td>
                        <td><?php echo $staff['S_email'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Phone Number</b></td>
                        <td>:</td>
                        <td><?php echo $staff['S_phoneNum'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>:</td>
                        <td><?php echo $staff['S_address'] ?? 'N/A'; ?></td>
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
</div>


<?php
// Close the database connection
$stmt->close();
$link->close();
?>
