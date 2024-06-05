<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKPark Dashboard</title>
    <style>

        
  
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
            justify-content: center;
            padding-left: 32%;
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
            margin-right: -70px; 
        }

        .avatar {
            cursor: pointer;
            vertical-align: middle;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .dropdown {
          float: left;
          overflow: hidden;
        }
        
        .dropdown .dropbtn {
          font-size: 16px;  
          border: none;
          outline: none;
          color: white;
          padding: 14px 16px;
          background-color: inherit;
          font-family: inherit;
          margin: 0;
        }
        
        .navbar a:hover, .dropdown:hover .dropbtn {
          background-color: red;
        }
        
        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
        }
        
        .dropdown-content a {
          float: none;
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
          text-align: left;
        }
        
        .dropdown-content a:hover {
          background-color: #ddd;
        }
        
        .dropdown:hover .dropdown-content {
          display: block;
        }
</style>


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
                    <li><a href="../../Module1/Admin/Dashbourd.php" style="padding-left: 10px">Dashboard</a></li>
                    <li>
                        <div class="dropdown">
                                <button class="dropbtn">Profile 
                                <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                <a href="../../Module1/Admin/Profile.php">My Profile</a>
                                <a href="#">User Profile</a>
                                </div>
                            </div> 
                    </li>
                    <li>
                        <div class="dropdown">
                                <button class="dropbtn">User 
                                <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                <a href="#">Users</a>
                                <a href="../../Module1/Admin/addUser.php">User Registration</a>
                                </div>
                            </div> 
                    </li>
                    <li>
                        <div class="dropdown">
                                <button class="dropbtn">Vehicle 
                                <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                <a href="#">User Vehicle</a>
                                </div>
                            </div> 
                    </li>
                    <li><a href="../../Logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <!-- Your main content here -->
         <!-- Your main content here -->
