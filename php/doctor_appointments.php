<?php
include '../php/connect.php';
session_start();

$doctorID = $_SESSION['UserID'];
$sql = "SELECT * FROM Appointments WHERE DoctorID = $doctorID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>AppointmentID</th><th>PatientID</th><th>AppointmentDate</th><th>AppointmentTime</th><th>Status</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['AppointmentID'] . '</td>';
        echo '<td>' . $row['PatientID'] . '</td>';
        echo '<td>' . $row['AppointmentDate'] . '</td>';
        echo '<td>' . $row['AppointmentTime'] . '</td>';
        echo '<td>' . $row['Status'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No appointments found.';
}

$conn->close();
