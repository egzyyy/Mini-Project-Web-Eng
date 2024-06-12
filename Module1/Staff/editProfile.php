<?php
// Include header file
// Start session and get staff ID
session_start();
require('../../Layout/staff_layout.php');

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
</head>
<body>
<div class="main">
    <h1>Edit Profile</h1>
    <div class="card">
        <div class="card-body">
            <form action="Profile.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $staff['S_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $staff['S_email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $staff['S_phoneNum']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" onclick="return confirm('Are you sure you want to update your profile?') value="<?php echo $staff['S_address']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
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
