<!DOCTYPE html>
<html>
<head>
    <title>Student Car Park Booking</title>
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
        }
        #main-header {
            background-color: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #ccc 3px solid;
        }
        #main-header h1 {
            text-align: center;
            text-transform: uppercase;
            margin: 0;
            font-size: 24px;
        }
        #navbar {
            display: flex;
            justify-content: center;
            padding: 10px;
            background: #333;
            color: white;
        }
        #navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }
        #navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        #main-content {
            margin: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px 0px #ccc;
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
        }
        .form-group button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header id="main-header">
        <div class="container">
            <h1>Student Car Park Booking</h1>
        </div>
    </header>

    <nav id="navbar">
        <a href="view_cars.php">View Cars</a>
        <a href="make_booking.php">Make Booking</a>
        <a href="view_booking.php">View Bookings</a>
    </nav>

    <div class="container" id="main-content">
        <!-- Placeholder for dynamic content -->
        <?php
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            include($page . '.php');
        } else {
            echo "<h2>Welcome to the Student Car Park Booking System</h2>";
        }
        ?>
    </div>
</body>
</html>
