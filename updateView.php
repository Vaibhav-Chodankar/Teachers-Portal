<?php

$id = $_POST['update'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "infipre_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed ". $conn->connect_error);
}

$sql = "SELECT * FROM student_details where id = " . $id;
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.css">
    <title>Update Student</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin-top: 70px;
        }

        form {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        nav {
            height: 50px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            margin-left: 30px;
            font-size: 1.7em;
            color: black;
            text-decoration: none;
        }

        .back-btn:hover {
            color: #007bff;
            transition: color 0.3s;
        }

        .profile-pic {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .pic-div {
            width: 300px;
            height: 100%;
            background-color: white;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .submit-btn {
            font-size: 1.2em;
        }
        .h5{
            font-size: 1.7em;
        }
    </style>
</head>
<body class="container">
    <nav class="fixed-top text-center">
        <a class="back-btn position-absolute top-0 start-0 mt-1" href="display.php"> <b>&larr;</b> </a>
        <span class="h5">Update Student</span>
    </nav>
    <main class="row justify-content-center mt-5 pt-4">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='pic-div me-4'>
                    <label class='form-label m-2 mt-1'>Current Profile Pic</label>
                    <img class='profile-pic' src='uploads/".$row['pic']."' >
                </div>
                <div class='form-area col-lg-8 col-md-10 col-12'>
                    <form action='update.php' method='post' enctype='multipart/form-data' class='row p-3'>
            
                        <div class='mb-3 col-2'>
                            <label for='name' class='form-label'>Title</label>
                            <select class='form-select' name='nameTitle'>
                                <option "; if($row['nametitle'] == 0) echo 'selected'; echo " value='0'>Mr</option>
                                <option "; if($row['nametitle'] == 1) echo 'selected'; echo " value='1'>Mrs</option>
                            </select>
                        </div>
            
                        <div class='mb-3 col-5'>
                            <label for='name' class='form-label'>Name*</label>
                            <input type='text' class='form-control image-input' id='name' name='name' value='".$row['name']."' placeholder='Tony Stark' required>
                        </div>
            
                        <div class='mb-3 col-4'>
                            <label for='contact' class='form-label'>Contact No.*</label>
                            <input type='text' class='form-control' id='contact' name='contact' value='".$row['phone']."' minlength='5' maxlength='15'
                                pattern='\d*' placeholder='9876543210' required>
                        </div>
            
                        <div class='mb-3 col-5'>
                            <label for='email' class='form-label'>Email*</label>
                            <input type='email' class='form-control' id='email' value='".$row['email']."' placeholder='example@gmail.com' name='email'
                                required>
                        </div>
            
                        <div class='mb-3 col-3 col-md-2'>
                            <label for='gender' class='form-label'>Gender</label>
                            <select class='form-select' id='gender' name='gender'>
                                <option "; if($row['gender'] == 0) echo 'selected'; echo " value='0'>Male</option>
                                <option "; if($row['gender'] == 1) echo 'selected'; echo " value='1'>Female</option>
                            </select>
                        </div>
            
                        <div class='mb-3 col-3 col-md-2'>
                            <label for='education' class='form-label'>Education</label>
                            <select class='form-select' id='education' name='education'>
                                <option "; if($row['education'] == 0) echo 'selected'; echo " value='0'>BSC</option>
                                <option "; if($row['education'] == 1) echo 'selected'; echo " value='1'>BCA</option>
                                <option "; if($row['education'] == 2) echo 'selected'; echo " value='2'>MCA</option>
                                <option "; if($row['education'] == 3) echo 'selected'; echo " value='3'>MSC</option>
                            </select>
                        </div>
            
                        <div class='mb-3 col-6'>
                            <label for='pic' class='form-label'>Change Profile Pic</label>
                            <input type='file' class='form-control' id='pic' name='pic'>
                            <a href='uploads/".$row['pic']."'>Current Pic</a>
                            <input type='hidden' value='".$row['pic']."' name='pic_name'>
                        </div>
                        
                        <div class='mb-3'>
                            <label for='address' class='form-label'>Address*</label>
                            <textarea class='form-control' id='address' rows='4' name='address' required
                                placeholder='Maximum 300 characters' onload='func()' maxlength='300'>".$row['address']."</textarea>
                                <div class='char-counter text-end'>
                                    <span id='charCount'>0</span>/300 characters
                                </div>
                        </div>
            
                        <div class='ms-1 mb-3 row justify-content-end'>
                            <button name='update' value='".$id."' class='btn btn-primary submit-btn col-3'>Update</button>
                        </div>
                    </form>
                </div>
                ";
            }
        } else {
            echo "<h4 class='mt-3 text-center'>No Student Data yet</h4>";
        }
        $conn->close();
        ?>
    </main>
    
    <script src='../bootstrap-5.3.3-dist/js/bootstrap.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var charCount = document.getElementById('address').value.length;
            document.getElementById('charCount').innerText = charCount;
        });

        document.getElementById('address').addEventListener('input', function () {
            var charCount = this.value.length;
            document.getElementById('charCount').innerText = charCount;
        });
    </script>
</body>
</html>
