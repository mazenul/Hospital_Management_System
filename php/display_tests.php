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

// Fetch medical tests
$sql = "SELECT TestName, TestPrice FROM MedicalTests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Test Name</th><th>Test Price</th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["TestName"] . '</td>';
        echo '<td>' . $row["TestPrice"] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No tests found.";
}

$conn->close();
?>
