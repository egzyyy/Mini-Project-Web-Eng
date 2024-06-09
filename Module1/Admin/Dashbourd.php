<?php
session_start();
    require('../../Layout/admin_layout.php');

    $link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}
// Include database connection file
mysqli_select_db($link, "web_eng");
?>

<link rel="stylesheet" href="Dashbourd.css">
<center>
<h2>Hello, <?php echo $_SESSION['user_username']; ?></h2>
</center>
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="dashboard-title">Dashboard</div>
            <div class="dashboard-actions">
            <form action="addUser.php" method="get" style="display:inline;">
                 <button type="submit" class="action-btn">Add User</button>
                </form>
                <button class="action-btn">View Report</button>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-title">Vehicles Registered</div>
                <div class="card-content">150</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">User Registered</div>
                <div class="card-content">25</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Traffic Summon Report</div>
                <div class="card-content">10</div>
            </div>
            <!-- Add more cards as needed -->
        </div>
    </div>
</div>
<div class="announcement-container">
    <marquee behavior="scroll" direction="left">
        Important Announcement!!
    </marquee>
    <div class="announcement-content">
        Date: 
        <div class="display-date">
            <span id="day"></span>
            <span id="daynum"></span>
            <span id="month"></span>
            <span id="year"></span>
        </div>
    </div>
</div>

<script src="Dashbourd.js"></script>
</main>
</body>
</html>
