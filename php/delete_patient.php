<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientID = $_POST['PatientID'];
    $sql = "DELETE FROM Users WHERE UserID = $patientID AND Role = 'Patient'";
    if ($conn->query($sql) === TRUE) {
        echo "Patient deleted successfully";
    } else {
        echo "Error deleting patient: " . $conn->error;
    }
    $conn->close();
}
