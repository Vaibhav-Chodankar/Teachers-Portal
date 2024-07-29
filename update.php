<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "infipre_db";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_POST['update'];
$nameTitle = $_POST['nameTitle'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$education = $_POST['education'];
$image = $_FILES['pic']['name'];

$file = $_FILES['pic'];
$fileTmpName = $file['tmp_name'];
$fileName = $file['name'];
$fileSize = $file['size'];
$fileError = $file['error'];
$fileType = $file['type'];
$targetDir = "uploads/";

$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$newFileName = uniqid('', true) . "." . $fileExt;
$targetFilePath = $targetDir . $newFileName;
if($image == ""){
    $newFileName = $_POST['pic_name'];
}
$sql = "UPDATE `student_details` SET `nametitle`='$nameTitle',`name`='$name',`phone`='$contact',`email`='$email',`gender`='$gender',`education`='$education',`address`='$address',`pic`='$newFileName' WHERE `id` = '$id'";
if (move_uploaded_file($fileTmpName, $targetFilePath)) {
    if (!($conn->query($sql) === TRUE)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "There was an error moving the uploaded file.";
}

session_start();

if ($conn->query($sql) === TRUE) {
    $_SESSION['alert'] = 'Record Updated successfully';
} else {
    $_SESSION['alert'] = 'Error Updating record: " . $conn->error';
}

$conn->close();

header('Location: display.php');
exit();