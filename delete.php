<?php
session_start();

if (isset($_POST['msg']) && isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "infipre_db";
    $image = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT pic FROM student_details WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    $filePath = "uploads/" . $image;
    
    $stmt = $conn->prepare("UPDATE student_details SET nametitle='deleted', name='deleted', phone='deleted', email='deleted', gender='deleted', education='deleted', address='deleted', pic='deleted' WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if($filePath != "uploads/default.jpg"){
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $_SESSION['alert'] = 'Record deleted successfully';
    } else {
        $_SESSION['alert'] = 'Error deleting record: ' . $conn->error;
    }
    $stmt->close();

    $conn->close();
} else {
    $_SESSION['alert'] = 'Invalid request';
}

header('Location: display.php');
exit();
