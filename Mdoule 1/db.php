<?php
// Connect to the MySQL server using mysqli
$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Create the database
$sql = "CREATE DATABASE IF NOT EXISTS web_eng";
if (mysqli_query($link, $sql)) {
    echo "Database created successfully\n";
} else {
    die('Error creating database: ' . mysqli_error($link));
}

// Select the database
mysqli_select_db($link, "web_eng");

// Create the users table
$sql1 = "CREATE TABLE IF NOT EXISTS user (
    U_Id INT AUTO_INCREMENT PRIMARY KEY,
    U_Username VARCHAR(50),
    U_Password VARCHAR(255),
    U_Type VARCHAR(50)
)";
if (mysqli_query($link, $sql)) {
    echo "Table users created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the vehicles table
$sql2 = "CREATE TABLE IF NOT EXISTS vehicle (
    V_vehicleID INT AUTO_INCREMENT PRIMARY KEY,
    V_plateNum VARCHAR(50),
    V_vehigrant VARCHAR(255),
    V_vehicleType VARCHAR(50),
    U_Id INT,
    FOREIGN KEY (U_Id) REFERENCES user(U_Id)
)";

$sql = "INSERT INTO user (U_Username, U_Password, U_Type)
VALUES ('Rusydan', 'rusydan040', 'staff')";

if (mysqli_query($link, $sql)) {
    echo "new record created successfully\n";
} else {
    die('Error creating new record: ' . mysqli_error($link));
}

// Close the connection
mysqli_close($link);
?>
