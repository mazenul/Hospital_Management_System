<?php
// Include the database connection
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and escape to prevent SQL injection
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password'])); // Hashing the password using MD5
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);

    // Insert user into the database
    $sql = "INSERT INTO Users (Username, Password, Role, FirstName, LastName, DOB, Gender, Address, Phone, Email, Specialty)
    VALUES ('$username', '$password', '$role', '$firstname', '$lastname', '$dob', '$gender', '$address', '$phone', '$email', '$specialty')";

    if ($conn->query($sql) === TRUE) {
       
        header("location: ../Pages/index.html");
        //echo' <script>alert("User registered successfully!");</script>';
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;

       

    }

    $conn->close();
    
}
