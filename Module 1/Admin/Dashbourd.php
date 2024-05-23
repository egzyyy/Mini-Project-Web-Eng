<?php
include('header.php');
?>

<link rel="stylesheet" href="Dashbourd.css">
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="dashboard-title">Dashboard</div>

            <div class="dashboard-actions">
                <button class="action-btn">Add new user</button>
                <button class="action-btn">Approve vehicle</button>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-title">New User</div>
                <div class="card-content">5</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">New Vehicle</div>
                <div class="card-content">20</div>
            </div>
            <div class="dashboard-card">
                <div class="card-title">Report Traffic Summon</div>
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
    <?php                        
    date_default_timezone_set("Asia/Kuala_Lumpur");
    echo date('d-m-Y H:i:s'); //Returns IST
    ?>
    </div>
</div>

<script src="Dashboard.js"></script>

<?php
include('../../footer/footer.php');
?>
