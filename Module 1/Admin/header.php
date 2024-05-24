<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKPark Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
  
        header {
            background-color: rgb(255, 99, 71); /* Tomato color */
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
            <div class="nav-center">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#user">User</a></li>
                    <li><a href="#vehicle">Vehicle</a></li>
                    <li><a href="../../Logout.php">Vehicle</a></li>
                </ul>
            </div>
            <div class="nav-right">
                <img src="avatar.png" class="profile" alt="Profile Picture">
            </div>
        </nav>
    </header>
    <main>
        <!-- Your main content here -->
    </main>
    <footer>
        <!-- Your footer content here -->
    </footer>
</body>
</html>
