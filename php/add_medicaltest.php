<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $testName = $_POST['medicaltestname'];
    $testPrice = $_POST['medicaltestprice'];
    $sql = "INSERT INTO MedicalTests (TestName, TestPrice) VALUES ('$testName', '$testPrice')";
    if ($conn->query($sql) === TRUE) {
        echo "Medical test added successfully";
    } else {
        echo "Error adding medical test: " . $conn->error;
    }
    $conn->close();
}
