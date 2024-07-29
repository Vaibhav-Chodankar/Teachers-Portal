<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE infipre_db";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully <br>";
} else {
    echo "Error creating database: " . $conn->error ."<br>";
}

mysqli_select_db($conn, "infipre_db");

$sql = "CREATE TABLE student_details (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nametitle BOOLEAN NOT NULL,
    name VARCHAR(30) NOT NULL,
    phone INTEGER(15) NOT NULL,
    email VARCHAR(30) NOT NULL,
    gender BOOLEAN NOT NULL,
    education INTEGER(10) NOT NULL,
    address VARCHAR(300) NOT NULL,
    pic VARCHAR(500) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();