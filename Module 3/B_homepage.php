<?php
include('../Layout/student_layout.php');
?>
<title>Student Car Park Booking</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        width: 80%;
        margin: auto;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    #main-content {
        margin: 20px;
        padding: 20px;
        background: white;
        box-shadow: 0px 0px 10px 0px #ccc;
        border-radius: 10px;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 32px;
    }
    .card {
        background-color: white;
        box-shadow: 0px 0px 10px 0px #ccc;
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
        border-radius: 10px;
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card h2 {
        margin-top: 0;
        font-size: 24px;
    }
    .nav-link {
        display: block;
        color: #333;
        padding: 14px 20px;
        text-decoration: none;
        border: 1px solid #ccc;
        margin: 10px auto;
        width: 200px;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
        font-size: 16px;
    }
    .nav-link i {
        margin-right: 8px;
    }
    .nav-link:hover {
        background-color: #ddd;
        color: black;
    }
    .form-group {
        margin: 10px 0;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .form-group button {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    .form-group button:hover {
        background-color: #555;
    }
</style>
<body>
    <div class="container" id="main-content">
        <h1>Welcome to the Student Car Park Booking System</h1>
        <div class="card">
            <h2><i class="fas fa-car"></i> View Cars</h2>
            <a class="nav-link" href="view_cars.php"><i class="fas fa-eye"></i> View Cars</a>
        </div>
        <div class="card">
            <h2><i class="fas fa-calendar-plus"></i> Make Booking</h2>
            <a class="nav-link" href="make_booking.php"><i class="fas fa-plus-circle"></i> Make Booking</a>
        </div>
        <div class="card">
            <h2><i class="fas fa-book"></i> View Bookings</h2>
            <a class="nav-link" href="view_booking.php"><i class="fas fa-eye"></i> View Bookings</a>
        </div>
    </div>
</body>
</html>
