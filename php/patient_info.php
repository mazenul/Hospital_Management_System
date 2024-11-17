<?php
// php/patient_info.php
session_start();
include 'connect.php';

if (isset($_SESSION['UserID']) && $_SESSION['Role'] == 'Patient') {
    $patientID = $_SESSION['UserID'];

    // Fetch patient details
    $sql = "SELECT * FROM Users WHERE UserID = $patientID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Name: " . $row['FirstName'] . " " . $row['LastName'] . "<br>";
        echo "DOB: " . $row['DOB'] . "<br>";
        echo "Gender: " . $row['Gender'] . "<br>";
        echo "Address: " . $row['Address'] . "<br>";
        echo "Phone: " . $row['Phone'] . "<br>";
        echo "Email: " . $row['Email'] . "<br>";
    }

    // Fetch and display appointments
    echo "<h3>Appointments</h3>";
    $sql = "SELECT Appointments.AppointmentID, Appointments.AppointmentDate, Appointments.AppointmentTime, Users.FirstName AS DoctorFirstName, Users.LastName AS DoctorLastName
            FROM Appointments 
            JOIN Users ON Appointments.DoctorID = Users.UserID 
            WHERE Appointments.PatientID = $patientID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Appointment ID: " . $row['AppointmentID'] . ", Date: " . $row['AppointmentDate'] . ", Time: " . $row['AppointmentTime'] . ", Doctor: Dr. " . $row['DoctorFirstName'] . " " . $row['DoctorLastName'] . "<br>";
        }
    } else {
        echo "No appointments found.";
    }

    // Fetch and display medical history
    echo "<h3>Medical History</h3>";
    $sql = "SELECT MedicalTests.TestName, PatientMedicalHistory.Description, PatientMedicalHistory.Date
            FROM PatientMedicalHistory 
            JOIN MedicalTests ON PatientMedicalHistory.TestID = MedicalTests.TestID
            WHERE PatientMedicalHistory.PatientID = $patientID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Date: " . $row['Date'] . ", Test: " . $row['TestName'] . ", Description: " . $row['Description'] . "<br>";
        }
    } else {
        echo "No medical history found.";
    }
    echo'<br>';
    // Add a button to navigate to appointment creation page
    echo '<a href="appointments.php" class="create-appointment-btn">Create Appointment</a>';

} else {
    echo "Unauthorized access.";
}
$conn->close();
