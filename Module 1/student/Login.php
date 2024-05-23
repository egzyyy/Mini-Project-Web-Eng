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
