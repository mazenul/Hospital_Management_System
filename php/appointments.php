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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $doctorID = mysqli_real_escape_string($conn, $_POST['doctor']);
    $patientName = mysqli_real_escape_string($conn, $_POST['patient']);
    $appointmentDate = mysqli_real_escape_string($conn, $_POST['date']);
    $appointmentTime = mysqli_real_escape_string($conn, $_POST['time']);

    // Get Patient ID based on Patient Name (assuming patient names are unique)
    $sqlPatient = "SELECT UserID FROM Users WHERE Role = 'Patient' AND CONCAT(FirstName, ' ', LastName) = '$patientName'";
    $resultPatient = $conn->query($sqlPatient);
    
    if ($resultPatient->num_rows > 0) {
        $rowPatient = $resultPatient->fetch_assoc();
        $patientID = $rowPatient['UserID'];

        // Insert appointment into the database
        $sql = "INSERT INTO Appointments (DoctorID, PatientID, AppointmentDate, AppointmentTime, Status)
                VALUES ('$doctorID', '$patientID', '$appointmentDate', '$appointmentTime', 'Pending')";

        if ($conn->query($sql) === TRUE) {
            echo "Appointment booked successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Patient not found.";
    }

    $conn->close();
}
?>
