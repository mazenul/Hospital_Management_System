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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $testName = mysqli_real_escape_string($conn, $_POST['testName']);
    $testPrice = mysqli_real_escape_string($conn, $_POST['testPrice']);

    // Insert medical test into the database
    $sql = "INSERT INTO MedicalTests (TestName, TestPrice) VALUES ('$testName', '$testPrice')";

    if ($conn->query($sql) === TRUE) {
        echo "New test added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
