<?php
session_start();
include 'connect.php';

if (isset($_SESSION['UserID']) && $_SESSION['Role'] == 'Patient') {
    $patientID = $_SESSION['UserID'];

    // Update bills to mark them as paid
    $sql = "UPDATE Bills SET PaymentStatus = 'Paid', PaymentDate = CURDATE() WHERE PatientID = $patientID AND PaymentStatus = 'Unpaid'";
    if ($conn->query($sql) === TRUE) {
        echo "All unpaid bills have been reset.";
        header("Location: ../php/patient.php"); // Redirect back to the dashboard
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Unauthorized access.";
}
$conn->close();
?>
