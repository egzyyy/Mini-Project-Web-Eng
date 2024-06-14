<!DOCTYPE html>
<html lang="en">
<head>
    <base href="http://localhost/projectWeb/Mini-Project-Web-Eng/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .content-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }
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
            background-color: #007B85;
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
            margin-left: 200px;
            flex: 1;
            flex-direction: row;
        }
        
        .sidenav {
            height: calc(200vh - 40px); /* Subtract header height */
            width: 250px;
            background-color: #D9DDDC;
            padding-top: 20px;
            overflow-x: hidden;
            color: #000000; 
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
            <h1>STUDENT</h1>
        </div>
        <div class="header-right">
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="image/loginIcon.png" alt="login">
                </button>
                <div class="dropdown-content">
                    <a href="Module1/Student/Profile.php">View Profile</a>
                    <a href="Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidenav">
            <a href="Module1/Student/Dashbourd.php">Dashboard</a>
            <button class="dropdown-btn">Vehicle 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="Module1/student/addVehicle.php">Registartion</a>
                <a href="Module1/student/infoVehicle.php">Information</a>
            </div>
            <button class="dropdown-btn">Booking
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="Module3/B_homepage.php">View Parking Spaces</a>
                <a href="Module3/view_booking.php">View Booking List</a>
            </div>
            <button class="dropdown-btn">Summon 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="Module4/scanSummon.php">View Summon Details</a>
                <a href="Module4/MySummon.php">My Summon</a>
            </div>        
        </div>
        <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
</body>
</html>
