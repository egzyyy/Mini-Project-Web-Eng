<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }

        .header-left {
            margin-left: 60px;
        }

        .header-left h1 {
            margin: 10px;
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
            width: 30px; /* Adjust the width of the image */
            height: 30px; /* Adjust the height of the image */
            border-radius: 50%; /* Optional: make the image round */
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
            padding: 20px 16px;
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
        }
        .sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar nav ul li {
            margin-bottom: 10px;
            padding: 10px;
        }
        .sidebar nav ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
            background-color: #ddd;
            border-radius: 5px;
            font-size: 20px;
            font-weight: bold;
        }
        .sidebar nav ul li a:hover {
            background-color: #ccc;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>ADMIN</h1>
        </div>
        <div class="header-right">
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="../image/loginIcon.png" alt="login">
                </button>
                <div class="dropdown-content">
                    <a href="#">Login</a>
                    <a href="#">Logout</a>
                    <a href="#">View Profile</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidebar">
            <nav>
                <ul>
                    <li><a href="#">User Registeration</a><li>
                    <li><a href="#">Manage Parking Spaces</a></li>
                    <li><a href="#">View Daily Available Parking Area</a></li>
                    <li><a href="#">Manage Parking Area</a></li>
                    <li><a href="#">Administration Dashboard</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
            <!-- Content goes here -->
        </div>
    </div>
</body>
</html>
