<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$role = $_POST['role'];
$username = $_POST['username'];
$password = md5($_POST['password']); // Hashing the password using MD5
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$specialty = $_POST['specialty'];

// Insert user into the database
$sql = "INSERT INTO Users (Username, Password, Role, FirstName, LastName, DOB, Gender, Address, Phone, Email, Specialty)
VALUES ('$username', '$password', '$role', '$firstname', '$lastname', '$dob', '$gender', '$address', '$phone', '$email', '$specialty')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
