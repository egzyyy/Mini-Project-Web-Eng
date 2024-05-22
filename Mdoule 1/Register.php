<?php

include('../header/home.php');

// Include database connection file
include('includes/db.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerbtn'])) {
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
$conn->close();
?>

<link rel="stylesheet" href="register.css">

        <!-- Home Section -->
        <section id="home">
            <center>
                <h1>Vehicle Details</h1>
            </center>
        </section>

        <!-- Login Modal -->
                <form action="Dashbourd.php" method="post">
                    <div class="reg_Form">
                        <p>Please fill in this form to get into your account.</p>
                        <hr>
                        <label for="Plate"><b>Plate Number</b></label>
                        <input type="text" placeholder="Plate" name="Plate" id="Plate" required>
                        <label for="Colour"><b>Colour</b></label>
                        <input type="text" placeholder="Colour" name="Colour" id="Colour" required>
                        <label for="License"><b>Driving License</b></label>
                        <input type="file" name="License" id="License" required>
                        <label for="grant"><b>Grant</b></label>
                        <input type="file" name="grant" id="grant" required>
                        <hr>
                        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
                        <button type="submit" class="registerbtn" id="registerbtn">Submit</button>
                    </div>
                    <div class="reg_Form signin">
                        <p>Already have an account? <a href="#">Sign in</a>.</p>
                    </div>
                </form>

        <?php
            include('../footer/footer.php');
        ?>

