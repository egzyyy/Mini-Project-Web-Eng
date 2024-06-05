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
    U_ID INT AUTO_INCREMENT PRIMARY KEY,
    U_Username VARCHAR(50),
    U_Password VARCHAR(255),
    U_Type VARCHAR(50)
)";
if (mysqli_query($link, $sql1)) {
    echo "Table users created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the staff table
$sql2 = "CREATE TABLE IF NOT EXISTS staff (
    S_staffID INT AUTO_INCREMENT PRIMARY KEY,
    S_name VARCHAR(100),
    S_phoneNum VARCHAR(20),
    S_address VARCHAR(250),
    S_email VARCHAR(100),
    U_ID INT,
    FOREIGN KEY (U_ID) REFERENCES user(U_ID)
)";
if (mysqli_query($link, $sql2)) {
    echo "Table staff created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the student table
$sql3 = "CREATE TABLE IF NOT EXISTS student (
    STU_studentID INT AUTO_INCREMENT PRIMARY KEY,
    STU_name VARCHAR(100),
    STU_type VARCHAR(20),
    STU_phoneNum VARCHAR(20),
    STU_yearStudy integer,
    STU_address VARCHAR(250),
    STU_email VARCHAR(100),
    STU_password VARCHAR(50),
    U_ID INT,
    FOREIGN KEY (U_ID) REFERENCES user(U_ID)
)";
if (mysqli_query($link, $sql3)) {
    echo "Table student created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the administrator table
$sql4 = "CREATE TABLE IF NOT EXISTS administrator (
    A_adminID INT AUTO_INCREMENT PRIMARY KEY,
    A_name VARCHAR(100),
    A_phoneNum VARCHAR(20),
    A_address VARCHAR(250),
    A_email VARCHAR (100),
    U_ID INT,
    FOREIGN KEY (U_ID) REFERENCES user(U_ID)
)";
if (mysqli_query($link, $sql4)) {
    echo "Table administrator created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the vehicle table
$sql5 = "CREATE TABLE IF NOT EXISTS vehicle (
    V_vehicleID INT AUTO_INCREMENT PRIMARY KEY,
    V_plateNum VARCHAR(50),
    V_vehigrant VARCHAR(255),
    V_vehicleType VARCHAR(50),
    U_ID INT,
    FOREIGN KEY (U_ID) REFERENCES user(U_ID)
)";

$sql1 = "INSERT INTO user (U_Username, U_Password, U_Type)
VALUES ('Rusydan', 'rusydan040', 'staff')";

if (mysqli_query($link, $sql)) {
    echo "new record created successfully\n";}
if (mysqli_query($link, $sql5)) {
    echo "Table vehicle created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the parkingSpace table
$sql6 = "CREATE TABLE IF NOT EXISTS parkingSpace (
    P_parkingSpaceID INT AUTO_INCREMENT PRIMARY KEY,
    P_location VARCHAR(15),
    P_status VARCHAR(30),
    P_parkingType VARCHAR(15)
)";
if (mysqli_query($link, $sql6)) {
    echo "Table parkingSpace created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the booking table
$sql7 = "CREATE TABLE IF NOT EXISTS booking (
    B_bookingID INT AUTO_INCREMENT PRIMARY KEY,
    B_startTime DATE,
    B_endTime DATE,
    P_parkingSpaceID INT,
    FOREIGN KEY (P_parkingSpaceID) REFERENCES parkingSpace(P_parkingSpaceID)
)";
if (mysqli_query($link, $sql7)) {
    echo "Table booking created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the trafficSummon table
$sql8 = "CREATE TABLE IF NOT EXISTS trafficSummon (
    TF_summonID INT AUTO_INCREMENT PRIMARY KEY,
    V_vehicleID INT,
    FOREIGN KEY (V_vehicleID) REFERENCES vehicle(V_vehicleID)
)";
if (mysqli_query($link, $sql8)) {
    echo "Table trafficSummon created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the demeritPoint table
$sql9 = "CREATE TABLE IF NOT EXISTS demeritPoint (
    DP_ID INT AUTO_INCREMENT PRIMARY KEY,
    V_type VARCHAR(50),
    V_date DATE,
    V_demeritPoint INT,
    V_description VARCHAR(250),
    TF_summonID INT,
    FOREIGN KEY (TF_summonID) REFERENCES trafficSummon(TF_summonID)
)";
if (mysqli_query($link, $sql9)) {
    echo "Table demeritPoint created successfully\n";
} else {
    die('Error creating new record: ' . mysqli_error($link));
}

$tab = "INSERT INTO user (U_ID, U_Username, U_Password, U_Type) 
        VALUES ('A100', 'fikri', 'fikri030', 'Student'), 
               ('B100', 'rusydan', 'rusydan040', 'Staff'), 
               ('BC100', 'iqmal', 'iqmal050', 'Administrator')";

if ($link->query($tab) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $tab . "<br>" . $link->error;
}

mysqli_close($link);
?>