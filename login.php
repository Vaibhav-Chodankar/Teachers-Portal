<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "infipre_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: index.html");
            } else {
                header("Location: student_dashboard.php");
            }
        } else {
            $_SESSION['alert'] = "Invalid password!";
            header("Location: LoginView.php");
        }
    } else {
        $_SESSION['alert'] = "Invalid username!";
        header("Location: LoginView.php");
    }
}

$conn->close();
?>
