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
<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff Profile</title>
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
        /* End */
    </style>
</head>
<body>
<div class="main">
    <h1>Edit Profile</h1>
    <div class="card">
        <div class="card-body">
            <form action="updateProfile.php" method="POST">
                <table>
                    <tr>
                        <td><label for="name">Name</label></td>
                        <td><input type="text" id="name" name="name" readonly value="<?php echo $staff['S_name']; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td><input type="email" id="email" name="email" value="<?php echo $staff['S_email']; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="phone">Phone Number</label></td>
                        <td><input type="tel" id="phone" name="phone" value="<?php echo $staff['S_phoneNum']; ?>" required></td>

                    </tr>
                    <tr>
                        <td><label for="address">Address</label></td>
                        <td><input type="text" id="address" name="address" value="<?php echo $staff['S_address']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>
                             <button type="submit" class="btn btn-save">Update</button>
                        </td>
                    </tr>
                </table>
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
