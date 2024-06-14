<?php
// Include header file
session_start();
require('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

mysqli_select_db($link, "web_eng");

$adminID = $_SESSION['A_adminID']; 

// Fetch administrator details
$query = "SELECT * FROM administrator WHERE A_adminID = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<div class="main">
    <h1>Profile</h1>
    <div class="card">
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td><b>Username</b></td>
                        <td>:</td>
                        <td><?php echo $admin['A_username'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Name</b></td>
                        <td>:</td>
                        <td><?php echo $admin['A_name'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>:</td>
                        <td><?php echo $admin['A_email'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Phone Number</b></td>
                        <td>:</td>
                        <td><?php echo $admin['A_phoneNum'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>:</td>
                        <td><?php echo $admin['A_address'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
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
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$link->close();
?>
