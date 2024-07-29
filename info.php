<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "infipre_db";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");

if ($result->num_rows == 0) {
    include 'db.php';
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
$sql = "INSERT INTO student_details (nametitle, name, phone, email, gender, education, address, pic) VALUES ('$nameTitle', '$name', '$contact', '$email', '$gender', '$education', '$address', '$newFileName')";
if (move_uploaded_file($fileTmpName, $targetFilePath)) {
    if (!($conn->query($sql) === TRUE)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "There was an error moving the uploaded file.";
}
$conn->close();

header('Location: display.php');

?>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.css">
    <title>Student Info</title>
    <style>
        body{
            background-color: antiquewhite;
            font-family: sans-serif;
        }
        
        main{
            background-color: #fefcfb;
            border:2px solid #fefcfb;
            border-radius: 10px;
            margin-top: 50px;
            margin-bottom: 80px;
        }

        .logo{
            width: 50px;
            height: 50px;
        }

        .profile-pic{
            border: 1px solid white;
            border-radius: 20px;
        }

        .btn-light {
            background-color: #e1d3c1;
        }

    </style>
</head>
<body class="container">

<main class="container">
    <div class="row">
        <h1 class="display-4 text-center my-4 col-12 align-items-center">Student Information</h1>
    </div>
    
    <hr>
    <div class="row">
        <h1 class="my-2"><b>Basic info</b></h1>
        <h3 class="col-12 my-2">
            Name: <?php if($nameTitle == 0) echo "Mr"; else echo "Mrs" ; echo". ". $name;?>
        </h3>
        
        <h3 class="col-6 my-2">
            Gender: <?php if($gender == 0) echo "Male"; else echo "Female" ?>
        </h3>

        <h3 class="col-6 my-2">
            Education: <?php if($education == 0) echo "BSC"; elseif($education == 1) echo "BCA"; elseif($education == 2) echo "MCA"; elseif($education == 3) echo "MSC"; ?>
        </h3>
        
        <h3 class="col-12 my-2">
            Address: <?php echo $address ?>
        </h3>
        <hr>
        <h1 class="my-2"><b>Contact</b></h1>

        <h3 class=" col-6 my-2">
            <img class="logo" src="https://t4.ftcdn.net/jpg/03/61/06/47/360_F_361064765_RP4yD79gKFMdHiaDmTUWiPES6aoAKPkb.jpg"> 
            <?php echo $contact ?>
        </h3>

        <h3 class="  col-6 my-2">
            <img class="logo" src="https://static.vecteezy.com/system/resources/previews/022/647/958/non_2x/email-icon-for-your-website-mobile-presentation-and-logo-design-free-vector.jpg"> 
            <?php echo $email ?>
        </h3>

        <hr>

    </div>    
    <div class="d-grid gap-2 my-4 mx-2">
        <a class="btn btn-light" href="./index.html">New Student</a> 
        <a class="btn btn-light" href="display.php">Display Students</a> 
    </div>
</main>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html> -->