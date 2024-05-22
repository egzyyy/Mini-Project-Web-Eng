<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKPark - Car Parking Management System</title>
    <link rel="stylesheet" href="home.css">
    <style>
            body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                header {
                    background-color: #333;
                    color: #fff;
                    padding: 15px 20px;
                }
                
                nav ul {
                    list-style-type: none;
                    margin: 0;
                    padding: 0;
                    text-align: center;
                }
                
                nav ul li {
                    display: inline;
                    margin: 0 15px;
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
  
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#" onclick="document.getElementById('loginModal').style.display='block'" style="width:auto;">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
