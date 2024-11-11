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

// Fetch doctors
$sql = "SELECT UserID, CONCAT(FirstName, ' ', LastName) AS DoctorName FROM Users WHERE Role = 'Doctor'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['UserID'] . '">' . $row['DoctorName'] . '</option>';
    }
} else {
    echo '<option value="">No doctors available</option>';
}

$conn->close();
?>
