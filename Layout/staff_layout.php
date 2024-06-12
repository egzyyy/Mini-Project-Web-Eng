<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
                body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #800000;
            color: white;
            padding: 30px 50px;
        }
        .header-left h1 {
            margin: 0;
        }
        .header-right {
            position: relative;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropbtn {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        .dropbtn img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            font-weight: bold;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .container {
            flex: 1;
            flex-direction: row;
        }
        .sidenav {
            height: calc(100vh - 40px); /* Subtract header height */
            width: 250px;
            background-color: #D9DDDC;
            padding-top: 20px;
            overflow-x: hidden;
            color: #000000;
            border-bottom-right-radius: 25px;    
            left: 0;
            overflow-x: hidden;
            position: absolute;
        }

        .sidenav a, .dropdown-btn {
            padding: 6px 8px 30px 16px;
            text-decoration:none ;
            font-size: 20px;
            color: #000000;
            display: block;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            color: #f1f1f1;
        }
        .main {
            margin-left: 200px;
            font-size: 20px;
            padding: 20px;
            flex: 1;
        }
        .active {
            background-color: green;
            color: white;
        }
        .dropdown-container {
            display: none;
            background-color: #808080;
            padding-left: 8px;
        }
        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 16px;}
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>STAFF</h1>
        </div>
        <div class="header-right">
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="../../image/loginIcon.png" alt="login">
                    Profile
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="../Module1/Student/Profile.php">View Profile</a>
                    <a href="../../Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidenav">
            <a href="../../Module1/Staff/Dashbourd.php">Dashboard</a>
            <div class="dropdown">
                <a href="#" class="dropdown-btn">Summon <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="../../Module 4/applySummon.php">Apply Summon</a>
                <div class="dropdown-content">
                    <a href="../../Module 4/trafficSummon.php">Traffic Summon</a>
                </div>
            </div>
            <a href="#">Manage Booking</a>
            <a href="#">Vehicle</a>
        </div>
        <div class="main">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
