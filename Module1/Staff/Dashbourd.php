<?php
session_start();
require('../../Layout/staff_layout.php');
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
                <button class="action-btn">Add summon</button>
                <a href="approve.php" class="action-btn">Approve</a>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-title">Total Warning</div>
                <div class="card-content">150</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Total Summon</div>
                <div class="card-content">25</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Pending Approve</div>
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


</main>
</body>
</html>

