<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "infipre_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (isset($_POST['submit'])) {
    $file_mimes = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

        $arr_file = explode('.', $_FILES['file']['name']);
        $extension = end($arr_file);

        if ('csv' == $extension) {
            $reader = IOFactory::createReader('Csv');
        } else {
            $reader = IOFactory::createReader('Xlsx');
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < count($sheetData); $i++) {
            $nametitle = $sheetData[$i][0];
            $name = $sheetData[$i][1];
            $phone = $sheetData[$i][2];
            $email = $sheetData[$i][3];
            $gender = $sheetData[$i][4];
            $education = $sheetData[$i][5];
            $address = $sheetData[$i][6];
            $pic = 'default.jpg';

            $sql = "INSERT INTO student_details (nametitle, name, phone, email, gender, education, address, pic) 
                    VALUES ('$nametitle', '$name', '$phone', '$email', '$gender', '$education', '$address', '$pic')";
            $conn->query($sql);
        }

        $_SESSION['alert'] = 'Records inserted successfully';
    } else {
        $_SESSION['alert'] = 'Please upload a valid excel file!';
    }
}
header("Location: display.php");

$conn->close();