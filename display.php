<?php
session_start();
if (isset($_SESSION['alert'])) {
    echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
            <strong>Attention</strong> " . $_SESSION['alert'] . "
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    unset($_SESSION['alert']);
}

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

$sql = "SELECT * FROM student_details ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.css">
    <title>Students</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            background-color: #fefcfb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 10px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-image {
            height: 200px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            object-fit: cover;
        }

        .card-body, .list-group-item {
            background-color: #fff;
        }

        nav {
            background-color: white;
            height: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
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

        #more {
            display: none;
        }

        #dots, #readless {
            color: #007bff;
            cursor: pointer;
        }
        .card-body{
            padding: 1rem;
        }
        .show-more,
        .show-less {
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }

        .hidden-content {
            display: none;
        }

        .excel-btn{
            margin-top: 32px;
        }

        @media screen and (max-width: 768px) {
            .excel-btn{
                margin-top: 5px;
            }
        }
    </style>
</head>
<body class="container pt-5">
    <nav class="fixed-top text-center py-2">
        <a class="back-btn position-absolute top-0 start-0 pt-1" href="index.html"><b>&larr;</b></a>
        <span class="h5">STUDENT'S</span>
    </nav>
    <main class="row justify-content-center">
        <form action="bunkupload.php" method="post" enctype="multipart/form-data" class="m-3 p-3 border rounded bg-white shadow-sm row">
            <div class="mb-3 col-12 col-md-6 col-xl-4">
                <label for="pic" class="form-label">Select Excel file to upload*</label>
                <input type="file" class="form-control" name="file" accept=".xls,.xlsx" required>
            </div>
            <div class="col-12 col-md-6 excel-btn">
                <a href="demo.xlsx" class="btn btn-success" download>Dummy file</a>
                <input type="submit" class="btn btn-success" name="submit" value="Upload">
            </div>
        </form>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['name'] == "deleted"){
                    continue;
                }
                echo "
                <div class='col-xl-3 col-lg-4 col-md-6 mb-4'>
                    <section class='card'>
                        <img src='uploads/".$row["pic"]."' class='card-img-top card-image' alt='profile pic'>
                        <div class='card-body'>
                            <h5 class='card-title'><b>"; if($row["nametitle"] == 0) echo "Mr"; else echo "Mrs"; echo ". ".$row["name"]."</b></h5>
                            <p class='card-text'>"; if($row["education"] == 0) echo "BSC"; elseif($row["education"] == 1) echo "BCA"; elseif($row["education"] == 2) echo "MCA"; elseif($row["education"] == 3) echo "MSC"; echo "</p>
                        </div>
                        <ul class='list-group list-group-flush'>
                            <li class='list-group-item'>".$row["phone"]."</li>
                            <li class='list-group-item'>".$row["email"]."</li>
                            <li class='list-group-item'>"; if($row["gender"] == 0) echo "Male"; else echo "Female"; echo"</li>
                        </ul>
                        <div class='card-body'>
                            <p class='card-text'>";
                                $address = $row["address"];
                                $show_characters = 20;

                                if (strlen($address) > $show_characters) {
                                    $visible_text = substr($address, 0, $show_characters);
                                    $hidden_text = substr($address, $show_characters);
                                    
                                    echo $visible_text . "
                                        <span class='show-more' onclick='showMore(this)'>... Show More</span>
                                        <span class='hidden-content'>" . $hidden_text . "
                                        <span class='show-less' onclick='showLess(this)'> Show Less</span></span>";
                                } else {
                                    echo $row["address"];
                                }
                            echo "</p>
                        </div>
                        <div class='card-body d-flex justify-content-end'>
                            <form action='updateView.php' method='post' class='d-inline'>
                                <button class='btn btn-primary' name='update' value='". $row['id'] ."'>Update</button>
                            </form>
                            <form action='delete.php' method='post' class='d-inline ms-2'>
                                <input type='hidden' name='msg' value='true'>
                                <button class='btn btn-danger' name='delete' value='". $row['id'] ."' onclick='return confirm(\"Are you sure, you want to delete this?\");'>Delete</button>
                            </form>
                        </div>
                    </section>
                </div>";
            }
        } else {
            echo "<h4 class='mt-3 text-center'>No Student Data yet</h4>";
        }
        $conn->close();
        ?>
    </main>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <script>
        function showMore(element) {
            const hiddenContent = element.nextElementSibling;
            hiddenContent.style.display = 'inline';
            element.style.display = 'none';
        }

        function showLess(element) {
            const hiddenContent = element.parentElement;
            hiddenContent.style.display = 'none';
            hiddenContent.previousElementSibling.style.display = 'inline';
        }
    </script>
</body>
</html>
