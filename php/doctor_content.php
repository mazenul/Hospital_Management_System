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

// Assuming DoctorID is stored in session after login
session_start();
$doctorID = $_SESSION['DoctorID'];

// Fetch doctor's details
$sql = "SELECT FirstName, LastName FROM Users WHERE UserID = $doctorID AND Role = 'Doctor'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctorName = $row['FirstName'] . " " . $row['LastName'];
    echo "<h2>Patient List for Dr. $doctorName</h2>";

    // Fetch patients under this doctor
    $sqlPatients = "SELECT Users.FirstName, Users.LastName, Appointments.AppointmentDate, Appointments.AppointmentTime 
                    FROM Users 
                    JOIN Appointments ON Users.UserID = Appointments.PatientID 
                    WHERE Appointments.DoctorID = $doctorID";
    $resultPatients = $conn->query($sqlPatients);

    if ($resultPatients->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>First Name</th><th>Last Name</th><th>Appointment Date</th><th>Appointment Time</th></tr>';
        while($rowPatients = $resultPatients->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowPatients["FirstName"] . '</td>';
            echo '<td>' . $rowPatients["LastName"] . '</td>';
            echo '<td>' . $rowPatients["AppointmentDate"] . '</td>';
            echo '<td>' . $rowPatients["AppointmentTime"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No patients found.";
    }
} else {
    echo "Doctor details not found.";
}

$conn->close();
?>
