<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $searchpat = $_GET['searchpat'];
    $sql = "SELECT * FROM Users WHERE Role = 'Patient' AND (Username LIKE '%$searchpat%' OR FirstName LIKE '%$searchpat%' OR LastName LIKE '%$searchpat%')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Patient ID: " . $row["UserID"] . " - Name: " . $row["FirstName"] . " " . $row["LastName"] . "<br>";
        }
    } else {
        echo "No patient found";
    }
    $conn->close();
}
