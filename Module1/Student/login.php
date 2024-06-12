
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FK Park Login</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad, #23a2f6);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right, #ff512f, #f09819);
            right: -30px;
            bottom: -80px;
        }

        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #080710;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input, select {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
            border: 1px solid #ced4da;
        }

        ::placeholder {
            color: #080710;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #007bff;
            color: #ffffff;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .forgot-password {
            text-align: center;
            margin-top: 30px;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php

$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}
// Include database connection file
mysqli_select_db($link, "web_eng");

// Check if form is submitted and the add_user button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    // Get form data
    $plate = $_POST['plate'];
    $type = $_POST['type'];
    $grant = $_POST['grant'];
    $username = $_SESSION['user_username'];

    // Prepare and execute the insert query
    $query = "INSERT INTO vehicle (V_plateNum, V_vehigrant, V_vehicleType, STU_username)
              VALUES (?, ?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ssss", $plate, $grant, $type, $username);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>New vehicle added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$link->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>FK Park Login</title>
    <!-- Add your CSS links and styles here -->
</head>
<body>
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
<form method="post">
    <h3>Student FKPark</h3>

    <label for="username">Username</label>
    <input type="text" placeholder="Username" id="username" name="username" required>

    <label for="password">Password</label>
    <input type="password" placeholder="Password" id="password" name="password" required>
    
    <div class="forgot-password">
        <a href="#">Forgot Password?</a>
    </div>
    <button type="submit" name="submit">Log In</button>
</form>
</body>
</html>

