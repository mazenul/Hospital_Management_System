<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $searchdoc = $_GET['searchdoc'];
    $sql = "SELECT * FROM Users WHERE Role = 'Doctor' AND (Username LIKE '%$searchdoc%' OR FirstName LIKE '%$searchdoc%' OR LastName LIKE '%$searchdoc%')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Doctor ID: " . $row["UserID"] . " - Name: " . $row["FirstName"] . " " . $row["LastName"] . "<br>";
        }
    } else {
        echo "No doctor found";
    }
    $conn->close();
}
