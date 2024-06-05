
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
session_start(); 
$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Select the database
mysqli_select_db($link, "web_eng");

if (isset($_POST['uname']) && isset($_POST['password'])) {

	$uname = $_POST['uname'];
	$pass = $_POST['password'];

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM user WHERE U_Username='$uname' AND U_Password='$pass'";

		$result = mysqli_query($link, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['U_Username'] === $uname && $row['U_Password'] === $pass) {
            	$_SESSION['U_Username'] = $row['U_Username'];
            	$_SESSION['U_Id'] = $row['U_Id'];
            	header("Location: Dashbourd.php");
		        exit();
            }else{
				header("Location: index.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: Dashbourd.php");
	exit();
}
?>

<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
<form method="post">
    <h3>Login FKPark</h3>

    <?php
    if ($error != "") {
        echo "<div class='error-message'>$error</div>";
    }
    ?>

    <label for="U_Username">Username</label>
    <input type="text" placeholder="Username" id="U_Username" name="U_Username" required>

    <label for="U_Password">Password</label>
    <input type="password" placeholder="Password" id="U_Password" name="U_Password" required>

    <label for="U_Type">Role</label>
    <select id="U_Type" name="U_Type">
        <option value="Administrator">Administrator</option>
        <option value="Staff Unit Keselamatan">Staff Unit Keselamatan</option>
        <option value="Student">Student</option>
    </select>
    
    <div class="forgot-password">
        <a href="#">Forgot Password?</a>
    </div>
    <button type="submit" name="submit">Log In</button>
</form>
</body>
</html>
