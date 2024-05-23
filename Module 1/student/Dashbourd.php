<?php
session_start();
    include('header.php');
?>

<link rel="stylesheet" href="Dashbourd.css">
<center>
<h2>Hello, <?php echo $_SESSION['U_Username']; ?></h2>
</center>
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="dashboard-title">Dashboard</div>
            <div class="dashboard-actions">
                <button class="action-btn">Add Vehicle</button>
                <button class="action-btn">View Booking History</button>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-title">Total Vehicles</div>
                <div class="card-content">150</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Available Spaces</div>
                <div class="card-content">25</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Traffic Summon</div>
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

<?php
    include('../../footer/footer.php');
?>
