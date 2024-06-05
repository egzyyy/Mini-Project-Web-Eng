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


        .logo {
            height: 80px; /* Adjust the height as needed */
            width: auto; /* Maintains the aspect ratio */
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
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <img src="image/logo.png" class="logo" alt="FKPark Logo">
            </div>
            <div class="nav-center">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#user">About</a></li>
                    <li>
                        <div class="dropdown">
                                <button class="dropbtn">Login 
                                <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">
                                <a href="../../Module1/Admin/loginPage.php">Administrator</a>
                                <a href="#">Staff Unit Keselamatan</a>
                                <a href="../../Module1/Student/loginPage.php">Student</a>
                                </div>
                            </div> 
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <!-- Your main content here -->

