<?php

include('../header/home.php');

// Include database connection file
include('db.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Get form data
    $uname = $_POST['U_Username'];
    $password = $_POST['U_Password'];
    $type = $_POST['U_Type'];

    // Prepare and execute the insert query
    $query = "INSERT INTO user (U_Username, U_Password, U_Type)
              VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $uname, $password, $type);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>New user added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$link->close();
?>
    <link rel="stylesheet" href="Login.css">

        <section id="home">
            <center>
                <h1>Welcome to FKPark</h1>
                <p>Manage your parking with ease.</p>
            </center>
        </section>

        <div id="loginModal" class="modal">
            <form class="modal-content animate" method="post" action="Register.php">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('loginModal').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="FKPark.jpg" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <?php if (isset($error)) echo "<p>$error</p>"; ?>
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="uname" required>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" required>

                    <label for="type"><b>Category</b></label>
                    <select name="type" id="type" required>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="student">Student</option>
                    </select>

                    <button type="submit" id="login">Login</button>
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <div class="psw">Forgot <a href="#">password?</a></div>
                </div>
            </form>
        </div>

        <?php
            include('../footer/footer.php');
        ?>
