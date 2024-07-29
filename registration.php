<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    
    <?php

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
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = 'admin';

        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

        try{
            if (($conn->query($sql) === TRUE)){
                header("Location: LoginView.php");
            }
        } catch(Exception $e){
            echo "<h1 style='text-align: center;margin-top:100px;padding:20px;'>Username already exist try <a href='LoginView.php'>Login</a></h1>";
        }
    }

    $conn->close();
    ?>

</body>
</html>
