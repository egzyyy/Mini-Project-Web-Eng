<?php
session_start();

$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $sql = "SELECT * FROM user WHERE U_Username = ? AND U_Password = ? AND U_Type = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // Authentication successful, redirect based on userType
        $user = $result->fetch_assoc();

        // Create new session ID
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $user['U_ID'];
        session_id($sessionId);

        $_SESSION["user_id"] = $user['U_ID'];
        $_SESSION["user_username"] = htmlspecialchars($user['U_Username']);
        $_SESSION['last_regeneration'] = time();

        switch ($user['U_Type']) {
            case 'Student':
                header("Location: Module1/Student/Dashboard.php?login=success");
                exit();
            case 'Administrator':
                header("Location: Module1/Admin/Dashboard.php?login=success");
                exit();
            case 'Staff Unit Keselamatan':
                header("Location: Module1/Staff/Dashboard.php?login=success");
                exit();
            default:
                // Handle unexpected role
                $message = "Invalid user type.";
                header("Location: loginPage.php?message=" . urlencode($message));
                exit();
        }
    } else {
        $message = "Invalid username or password.";
        header("Location: loginPage.php?message=" . urlencode($message));
        exit();
    }
}
?>