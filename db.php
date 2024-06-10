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
    STU_studentID INT PRIMARY KEY,
    STU_name VARCHAR(100),
    STU_type VARCHAR(20),
    STU_phoneNum VARCHAR(20),
    STU_yearStudy INTEGER,
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
    V_vehicleType VARCHAR(50)
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
    student_id VARCHAR(50),
    date DATE,
    status ENUM('Paid', 'Unpaid'),
    plate_number VARCHAR(50),
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

// Check if the flag file exists
$flagFile = 'data_inserted.flag';

if (!file_exists($flagFile)) {
    // Insert sample data
    $tab1 = "INSERT INTO user (U_Username, U_Password, U_Type) 
            VALUES ('fikri', 'fikri030', 'Student'), 
                   ('rusydan', 'rusydan040', 'Staff'), 
                   ('iqmal', 'iqmal050', 'Administrator')";

    if ($link->query($tab1) === TRUE) {
        echo "New records created successfully\n";
    } else {
        echo "Error: " . $tab1 . "<br>" . $link->error;
    }

    $tab2 = "INSERT INTO vehicle (V_plateNum, V_vehigrant, V_vehicleType) 
            VALUES ('www111', 'de', 'ford'), 
                   ('www222', 'de', 'ranger'), 
                   ('www333', 'de', 'rover')";

    if ($link->query($tab2) === TRUE) {
        echo "New records created successfully\n";
    } else {
        echo "Error: " . $tab2 . "<br>" . $link->error;
    }

    // Create the flag file to indicate data has been inserted
    file_put_contents($flagFile, 'Data inserted');
}

// Do not close the database connection here
?>
