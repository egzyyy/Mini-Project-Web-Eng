<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "web_eng";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM trafficSummon";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Violations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="#">ACADEMIC</a>
            <a href="#">ABOUT</a>
            <a href="#">UNIT KESELAMATAN</a>
        </div>
    </header>
    <main>
        <section class="content">
            <h2>Parking</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Plate Number</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["student_id"] . "</td>";
                            echo "<td>" . $row["plate_number"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo '<td>';
                            if ($row["status"] == "Unpaid") {
                                echo '<button class="btn cancel" onclick="cancelSummon(' . $row["TF_summonID"] . ')">Cancel</button>';
                            } else {
                                echo '<button class="btn delete" onclick="deleteSummon(' . $row["TF_summonID"] . ')">Delete</button>';
                            }
                            echo '</td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No summons found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <div class="footer-nav">
            <a href="#">Profile</a>
            <a href="#">Parking</a>
            <a href="#">Home</a>
            <a href="#">Summon</a>
            <a href="#">Dashboard</a>
            <a href="#">Vehicle</a>
        </div>
    </footer>
    <script>
        function cancelSummon(id) {
            if (confirm("Are you sure you want to cancel this summon?")) {
                window.location.href = 'cancel_summon.php?id=' + id;
            }
        }

        function deleteSummon(id) {
            if (confirm("Are you sure you want to delete this summon?")) {
                window.location.href = 'delete_summon.php?id=' + id;
            }
        }
    </script>
</body>
</html>
