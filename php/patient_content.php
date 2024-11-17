<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming PatientID is stored in session after login
session_start();
$patientID = $_SESSION['PatientID'];

// Fetch patient's details
$sql = "SELECT FirstName, LastName FROM Users WHERE UserID = $patientID AND Role = 'Patient'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $patientName = $row['FirstName'] . " " . $row['LastName'];
    echo "<h2>Profile for $patientName</h2>";

    // Fetch appointments
    echo "<h3>Appointments</h3>";
    $sqlAppointments = "SELECT Appointments.AppointmentDate, Appointments.AppointmentTime, Users.FirstName AS DoctorFirstName, Users.LastName AS DoctorLastName
                        FROM Appointments 
                        JOIN Users ON Appointments.DoctorID = Users.UserID
                        WHERE Appointments.PatientID = $patientID";
    $resultAppointments = $conn->query($sqlAppointments);

    if ($resultAppointments->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Date</th><th>Time</th><th>Doctor</th></tr>';
        while($rowAppointments = $resultAppointments->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowAppointments["AppointmentDate"] . '</td>';
            echo '<td>' . $rowAppointments["AppointmentTime"] . '</td>';
            echo '<td>Dr. ' . $rowAppointments["DoctorFirstName"] . ' ' . $rowAppointments["DoctorLastName"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No appointments found.";
    }

    // Fetch medical history
    echo "<h3>Medical History</h3>";
    $sqlHistory = "SELECT MedicalTests.TestName, PatientMedicalHistory.Description, PatientMedicalHistory.Date
                   FROM PatientMedicalHistory
                   JOIN MedicalTests ON PatientMedicalHistory.TestID = MedicalTests.TestID
                   WHERE PatientMedicalHistory.PatientID = $patientID";
    $resultHistory = $conn->query($sqlHistory);

    if ($resultHistory->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Date</th><th>Test</th><th>Description</th></tr>';
        while($rowHistory = $resultHistory->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowHistory["Date"] . '</td>';
            echo '<td>' . $rowHistory["TestName"] . '</td>';
            echo '<td>' . $rowHistory["Description"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No medical history found.";
    }

} else {
    echo "Patient details not found.";
}
// Add a button to navigate to appointment creation page
echo '<a href="appointment.php" class="create-appointment-btn">Create Appointment</a>';
$conn->close();
?>
