<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctorID = $_POST['doctorid'];
    $sql = "DELETE FROM Users WHERE UserID = $doctorID AND Role = 'Doctor'";
    if ($conn->query($sql) === TRUE) {
        echo "Doctor deleted successfully";
    } else {
        echo "Error deleting doctor: " . $conn->error;
    }
    $conn->close();
}
