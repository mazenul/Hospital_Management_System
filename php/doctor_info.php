<?php
// php/doctor_info.php
session_start();
include 'connect.php';

if (isset($_SESSION['UserID']) && $_SESSION['Role'] == 'Doctor') {
    $doctorID = $_SESSION['UserID'];

    $sql = "SELECT * FROM Users WHERE UserID = $doctorID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Name: " . $row['FirstName'] . " " . $row['LastName'] . "<br>";
        echo "Specialty: " . $row['Specialty'] . "<br>";
        // Add more fields as needed
    }

    // Fetch and display appointments
    echo "<h3>Appointments</h3>";
    $sql = "SELECT * FROM Appointments WHERE DoctorID = $doctorID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Appointment ID: " . $row['AppointmentID'] . ", Patient ID: " . $row['PatientID'] . ", Date: " . $row['AppointmentDate'] . ", Time: " . $row['AppointmentTime'] . "<br>";
        }
    } else {
        echo "No appointments found.";
    }
} else {
    echo "Unauthorized access";
}
$conn->close();
?>
