<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKPark</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
  
        header {
            background-color: #007B85; /* Tomato color */
            color: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
  
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
  
        .nav-left, .nav-right {
            display: flex;
            align-items: center;
        }
  
        .nav-center {
            flex: 1;
            display: flex;
            justify-content: center;
        }
  
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 20px; /* Adds space between menu items */
        }
  
        nav ul li {
            margin: 0;
        }
  
        nav ul li a {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
  
        main {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .logo {
            height: 80px; /* Adjust the height as needed */
            width: auto; /* Maintains the aspect ratio */
        }

        .profile {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            cursor: pointer;
        }

        .profile-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .profile-menu li {
            margin-left: 15px;
        }

        .profile-menu li a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <img src="logo.png" class="logo" alt="FKPark Logo">
            </div>
            <center>
            <div class="nav-center">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#user">About</a></li>
                    <li><a onclick="document.getElementById('loginModal').style.display='block'" style="width:auto;">Login</a></li>
                </ul>
            </div>
            </center>
            <div class="nav-right">
                <img src="avatar.png" class="profile" alt="Profile Picture">
            </div>
        </nav>
    </header>
    <main>
        <!-- Your main content here -->
