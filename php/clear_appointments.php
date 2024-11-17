<?php
// php/clear_appointments.php
session_start();
include 'connect.php';

if (isset($_SESSION['UserID']) && $_SESSION['Role'] == 'Doctor') {
    $doctorID = $_SESSION['UserID'];

    $sql = "DELETE FROM Appointments WHERE DoctorID = $doctorID";
    if ($conn->query($sql) === TRUE) {
        echo "Appointments cleared successfully.";
        header("Location: ../php/doctor.php");    
    } else {
        echo "Error clearing appointments: " . $conn->error;
    }
} else {
    echo "Unauthorized access";
}
$conn->close();
