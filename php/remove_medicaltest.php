<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $testID = $_POST['medicaltestid'];
    $sql = "DELETE FROM MedicalTests WHERE TestID = $testID";
    if ($conn->query($sql) === TRUE) {
        echo "Medical test removed successfully";
    } else {
        echo "Error removing medical test: " . $conn->error;
    }
    $conn->close();
}
