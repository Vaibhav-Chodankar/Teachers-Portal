<?php
session_start();
if (isset($_SESSION['alert'])) {
    echo "<script>
        alert('" . $_SESSION['alert'] . "');
    </script>";
    unset($_SESSION['alert']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.css">
    <title>Sign in</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-size: 3rem;
            padding-right: 20px;
            margin: 0;
            color: #007bff;
        }

        h1:hover {
            color: #0056b3;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 800px;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            width: 100%;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control, .form-select {
            border-radius: 5px;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .form-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .form-link:hover {
            color: #0056b3;
        }

        @media screen and (max-width: 992px) {
            h1 {
                font-size: 2.5rem;
                text-align: left;
            }

            main {
                padding: 20px;
            }

            .submit-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body class="container">
<a href="Home.html" class="position-absolute top-0 start-0 m-3">
        <img class="logout-img"
            src="https://cdn-icons-png.flaticon.com/512/3114/3114883.png"
            alt="Logout" width="30" height="30">
    </a>
    <main class="row align-items-center">
        <section class="col-lg-6 text-end">
            <h1>SIGN IN</h1>
        </section>

        <form action="registration.php" method="post" class="col-lg-6">
            <div class="mb-3 ">
                <label for="username" class="form-label">Username*</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password*</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- <div class="mb-3 col-8 col-sm-10 col-md-6 col-lg-6">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role">
                    <option value="student">Student</option>
                    <option selected value="admin">Admin</option>
                </select>
            </div>
             -->
            <div class="mb-3">
                <button type="submit" class="btn submit-btn">Sign in</button><br>
                <a class="form-link ms-1" href="LoginView.php">Already a user? Try login</a>
            </div>
        </form>
    </main>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>

</html>
