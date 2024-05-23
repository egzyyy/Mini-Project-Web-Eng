<?php
session_start();
include('db.php');

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['type'])) {
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);
    $type = validate($_POST['type']);

    if (empty($uname)) {
        header("Location: ../index.php?error=Username is required");
        exit();
    } else if (empty($password)) {
        header("Location: ../index.php?error=Password is required");
        exit();
    } else if (empty($type)) {
        header("Location: ../index.php?error=Type is required");
        exit();
    }

    $sql = "SELECT * FROM user WHERE U_Username='$uname' AND U_Password='$password' AND U_Type='$type'";
    $result = mysqli_query($link, $sql1);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['U_Username'] === $uname && $row['U_Password'] === $password) {
            $_SESSION['U_Username'] = $row['U_Username'];
            $_SESSION['U_Password'] = $row['U_Password'];
            $_SESSION['U_Type'] = $row['U_Type'];
            header("Location: Dashbourd.php");
            exit();
        } else {
            header("Location: ../index.php?error=Incorrect Username or Password");
            exit();
        }
    } else {
        header("Location: ../index.php?error=Incorrect Username or Password");
        exit();
    }
} else {
    header("Location: ../index.php?error=All fields are required");
    exit();
}
?>
