<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f4; /* Light grey background */
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #800000; /* Maroon header background */
            color: white;
            padding: 30px 50px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
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
            background-color: #800000;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 5px; /* Changed to rectangle shape */
            transition: background-color 0.3s;
        }
        .dropbtn img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
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
            display: flex;
            flex: 1;
            flex-direction: row;
        }
        .sidenav {
            height: calc(100vh - 40px); /* Subtract header height */
            width: 250px;
            background-color: #800000; /* Maroon sidebar background */
            padding-top: 20px;
            position: fixed;
            overflow-x: hidden;
            color: white;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
            position: absolute;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 16px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            background-color: #571515; /* Darker maroon on hover */
        }
        .main {
            margin-left: 250px; /* Width of sidebar */
            font-size: 20px;
            padding: 20px;
            flex: 1;
            background-color: #fff; /* White main content background */
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
        }
        .active {
            background-color: green;
            color: white;
        }
        .dropdown-container {
            display: none;
            background-color: #262626;
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
                    <img src="../../image/profileIcon.png" alt="Profile">
                    Profile
                </button>
                <div class="dropdown-content">
                    <a href="../Module1/Admin/Profile.php">View Profile</a>
                    <a href="../../Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidenav">
            <a href="#">Dashboard</a>
            <a href="#">Apply Summon</a>
            <a href="#">Manage Booking</a>
        </div>
    </div>
</body>
</html>
