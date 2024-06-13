<?php
session_start();
require('../../Layout/student_layout.php');

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Get the logged-in user's student ID from the session
$studentID = $_SESSION['STU_studentID'];

// Query to count the total number of vehicles registered by the logged-in user
$query_total_vehicles = "SELECT COUNT(*) AS total_vehicles FROM vehicle WHERE STU_studentID = ?";
$stmt = $link->prepare($query_total_vehicles);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
    $total_vehicles = $row['total_vehicles'];
} else {
    $total_vehicles = 0;
}

$stmt->close();
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    height: 100%;
}

.avatar {
    height: 10px;
    width: 10px;
    border-radius: 50%;
}

.dashboard-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 10px;
}

.dashboard-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 1200px;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.dashboard-title {
    font-size: 24px;
    font-weight: bold;
}

.dashboard-actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    padding: 10px 20px;
    background-color: #2a45f1;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.action-btn:hover {
    background-color: #1e326b;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.dashboard-card {
    background-color: #f8f8f8;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-content {
    font-size: 14px;
}

.announcement-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 10px;
}

.announcement-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 1200px;
    padding-bottom: 60px;
}

.announcement-text {
    font-size: 16px;
    color: #333;
}

.display-date {
    text-align: center;
    margin-bottom: 10px;
    font-size: 1.6rem;
    font-weight: 600;
}
</style>
</head>
<body>
<center>
<h2>Hello, <?php echo $_SESSION['STU_name']; ?></h2>
</center>
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="dashboard-title">Dashboard</div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-title">Total Vehicles Registered</div>
                <div class="card-content"><?php echo $total_vehicles; ?></div>
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
  
</body>
</html>
