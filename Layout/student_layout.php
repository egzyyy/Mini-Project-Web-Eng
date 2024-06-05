<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            background-color: #333;
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
            display: flex;
            flex: 1;
            flex-direction: row;
        }
        .sidenav {
            height: calc(100vh - 40px); /* Subtract header height */
            width: 200px;
            background-color: #111;
            padding-top: 20px;
            position: fixed;
            overflow-x: hidden;
            color: #333;
    border-bottom-right-radius: 25px;
    height: 86%;
    left: 0;
    overflow-x: hidden;
    padding-top: 20px;
    position: absolute;
    width: 250px;
        }
        .sidenav a, .dropdown-btn {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
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
            background-color: #262626;
            padding-left: 8px;
        }
        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>STUDENT</h1>
        </div>
        <div class="header-right">
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="../../image/loginIcon.png" alt="login">
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
            <a href="#">Profile</a>
            <button class="dropdown-btn">User 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="#">Manage User</a>
                <a href="#">Profile</a>
                <a href="#">Registration</a>
            </div>
            <a href="#">Manage Parking Area</a>
            <a href="#">Administration Dashboard</a>
        </div>
        <div class="main">

