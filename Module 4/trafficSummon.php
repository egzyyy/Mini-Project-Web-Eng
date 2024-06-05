<?php
include('../Layout/staff_layout.php');

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
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        /* Main content container */
        .content-container {
            max-width: 800px;
            margin-left: 425px;
            margin-bottom: 250px;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            text-align: center;
        }

        .content-container h2 {
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Form styling */
        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            margin-top: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            border-radius: 4px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="date"],
        form select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #575757;
        }

        .btn.cancel {
            background-color: #ff9800;
        }

        .btn.cancel:hover {
            background-color: #e68900;
        }

        .btn.delete {
            background-color: #f44336;
        }

        .btn.delete:hover {
            background-color: #d32f2f;
        }

    </style>
</head>
<body>

    <main>
        <div class="content-container">
            <h2>Parking Violations</h2>
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
        </div>
    </main>
    <script>
        function cancelSummon(id) {
            if (confirm("Are you sure you want to cancel this summon?")) {
                window.location.href = 'cancel.php?id=' + id;
            }
        }

        function deleteSummon(id) {
            if (confirm("Are you sure you want to delete this summon?")) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>
