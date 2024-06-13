<?php
session_start();
require('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Fetch administrator details
$query = "SELECT * FROM administrator WHERE A_adminID = ?";
// Start session and get administrator ID
$adminID = $_SESSION['A_adminID']; 
$stmt = $link->prepare($query);
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $address = $_POST['address'];

    // Update administrator details
    $update_query = "UPDATE administrator SET A_name = ?, A_email = ?, A_phoneNum = ?, A_address = ? WHERE A_adminID = ?";
    $stmt_update = $link->prepare($update_query);
    $stmt_update->bind_param("ssssi", $name, $email, $phoneNum, $address, $adminID);

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
    <h2>EDIT PROFILE</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="Profile.php">
                <table>
                    <tbody>
                        <tr>
                            <td><b>Name</b></td>
                            <td>:</td>
                            <td><input type="text" name="name" readonly value="<?php echo $admin['A_name'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>:</td>
                            <td><input type="email" name="email" value="<?php echo $admin['A_email'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Phone Number</b></td>
                            <td>:</td>
                            <td><input type="text" name="phoneNum" value="<?php echo $admin['A_phoneNum'] ?? ''; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>:</td>
                            <td><input type="text" name="address" value="<?php echo $admin['A_address'] ?? ''; ?>"></td>
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
