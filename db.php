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
    S_username VARCHAR(100),
    S_name VARCHAR(100),
    S_phoneNum VARCHAR(20),
    S_address VARCHAR(250),
    S_email VARCHAR(100),
    S_password VARCHAR(255)
)";
if (mysqli_query($link, $sql2)) {
    echo "Table staff created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the student table
$sql3 = "CREATE TABLE IF NOT EXISTS student (
    STU_studentID INT AUTO_INCREMENT PRIMARY KEY,
    STU_username VARCHAR(100),
    STU_name VARCHAR(100),
    STU_type VARCHAR(20),
    STU_phoneNum VARCHAR(20),
    STU_yearStudy INTEGER,
    STU_address VARCHAR(250),
    STU_email VARCHAR(100),
    STU_password VARCHAR(50)
)";
if (mysqli_query($link, $sql3)) {
    echo "Table student created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the administrator table
$sql4 = "CREATE TABLE IF NOT EXISTS administrator (
    A_adminID INT AUTO_INCREMENT PRIMARY KEY,
    A_username VARCHAR(100),
    A_name VARCHAR(100),
    A_phoneNum VARCHAR(20),
    A_address VARCHAR(250),
    A_email VARCHAR (100),
    A_password VARCHAR(255)
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
    STU_username VARCHAR(10),
    FOREIGN KEY (STU_username) REFERENCES student(STU_username)
)";
if (mysqli_query($link, $sql5)) {
    echo "Table vehicle created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Create the parkingSpace table
$sql6 = "CREATE TABLE IF NOT EXISTS parkingSpace (
    P_parkingSpaceID VARCHAR(6) PRIMARY KEY,
    P_location VARCHAR(15),
    P_status VARCHAR(30),
    P_parkingType VARCHAR(15),
    P_reason VARCHAR(100) NULL
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
    P_parkingSpaceID VARCHAR(6),
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
    TF_date DATE,
    TF_status ENUM('Paid', 'Unpaid'),
    TF_violationType VARCHAR(200),
    TF_demeritPoint INT,
    FOREIGN KEY (V_vehicleID) REFERENCES vehicle(V_vehicleID)
)";
if (mysqli_query($link, $sql8)) {
    echo "Table trafficSummon created successfully\n";
} else {
    die('Error creating table: ' . mysqli_error($link));
}

// Insert sample data if flag file doesn't exist
$flagFile = 'data_inserted.flag';

if (!file_exists($flagFile)) {
    // Insert sample data into the user table
    $tab1 = "INSERT INTO user (U_Username, U_Password, U_Type) 
            VALUES ('fikri', 'fikri030', 'Student'), 
                   ('rusydan', 'rusydan040', 'Staff'), 
                   ('iqmal', 'iqmal050', 'Administrator')";

    if (mysqli_query($link, $tab1)) {
        echo "New records created successfully in user table\n";
    } else {
        die('Error: ' . $tab1 . "<br>" . mysqli_error($link));
    }

    // Insert sample data into the vehicle table
    $tab2 = "INSERT INTO vehicle (V_plateNum, V_vehigrant, V_vehicleType) 
            VALUES ('abc111', 'de', 'ford'), 
                   ('abc222', 'de', 'ranger'), 
                   ('abc333', 'de', 'rover')";

    if (mysqli_query($link, $tab2)) {
        echo "New records created successfully in vehicle table\n";
    } else {
        die('Error: ' . $tab2 . "<br>" . mysqli_error($link));
    }

    // Create the flag file to indicate data has been inserted
    file_put_contents($flagFile, 'Data inserted');
} else {
    echo "Data already inserted. Skipping insertion.\n";
}

// Close the database connection
mysqli_close($link);
?>
