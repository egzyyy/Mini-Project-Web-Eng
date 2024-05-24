<?php 
session_start(); 
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['type'])) {

	$uname = $_POST['uname'];
	$pass = $_POST['password'];
	$type = $_POST['type'];

	if (empty($uname)) {
		header("Location: index.php?error=Username is required");
	    exit();
	} else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
	    exit();
	} else if (empty($type)) {
        header("Location: index.php?error=Type is required");
	    exit();
	} else {
		$sql = "SELECT * FROM user WHERE U_Username='$uname' AND U_Password='$pass'";

		$result = mysqli_query($link, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['U_Username'] === $uname && $row['U_Password'] === $pass) {
            	$_SESSION['U_Username'] = $row['U_Username'];
            	$_SESSION['U_ID'] = $row['U_ID'];
				if ($type == 'admin'){
					header("Location: Module1/Admin/Dashbourd.php");
				} else if ($type == 'staff'){
					header("Location: Module1/Staff/Dashbourd.php");
				} else if ($type == 'student'){
					header("Location: Module1/Student/Dashbourd.php");
				}
		        exit();
            } else {
				header("Location: index.php?error=Incorrect Username or Password");
		        exit();
			}
		} else {
			header("Location: index.php?error=Incorrect Username or Password");
	        exit();
		}
	}
} else {
	header("Location: index.php");
	exit();
}
?>
