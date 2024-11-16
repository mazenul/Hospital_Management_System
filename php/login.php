<?php
// php/login.php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $sql = "SELECT * FROM Users WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['UserID'] = $row['UserID'];
        $_SESSION['Role'] = $row['Role'];

        switch ($row['Role']) {
            case 'Admin':
                header('Location: ../Pages/admin.html');
                break;
            case 'Doctor':
                header('Location: ../php/doctor.php');
                break;
            case 'Patient':
                header('Location: ../php/patient.php');
                break;
        }
        exit();
    } else {
        echo "Invalid username or password";
    }
}
$conn->close();
