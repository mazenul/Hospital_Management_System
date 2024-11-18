<?php
session_start();
include 'connect.php';

if (isset($_SESSION['UserID']) && $_SESSION['Role'] == 'Patient') {
    $patientID = $_SESSION['UserID'];
    $testID = $_POST['testID'];
    $description = $_POST['description'];

    // Insert test into PatientMedicalHistory
    $sql = "INSERT INTO PatientMedicalHistory (PatientID, TestID, Description, Date) VALUES ($patientID, $testID, '$description', CURDATE())";
    if ($conn->query($sql) === TRUE) {
        echo "Medical test added successfully.";
        header("Location: ../php/patient.php"); // Redirect back to the dashboard
    } else {
        echo "Error: " . $conn->error;
    }

    // Create a bill for the test
    $sql = "SELECT TestPrice FROM MedicalTests WHERE TestID = $testID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $amount = $row['TestPrice'];

        $sql = "INSERT INTO Bills (PatientID, TestID, Amount, PaymentStatus) VALUES ($patientID, $testID, $amount, 'Unpaid')";
        if ($conn->query($sql) === TRUE) {
            echo "Bill created successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Unauthorized access.";
}
$conn->close();
?>
