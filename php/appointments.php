<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$patientID = $_SESSION['UserID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle appointment creation
    $doctorID = $_POST['doctor_id'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];

    // Convert time to 24-hour format for comparison
    $appointmentTime24 = date("H:i", strtotime($appointmentTime));
    $startTime = "12:00";
    $endTime = "22:00";

    // Check if the appointment time is within the allowed range
    if ($appointmentTime24 < $startTime || $appointmentTime24 > $endTime) {
        echo "<script>alert('Appointment time must be between 12:00 PM and 10:00 PM.');</script>";
    } else {
        // Check if the doctor already has an appointment at the same time
        $sqlCheck = "SELECT * FROM Appointments 
                     WHERE DoctorID = $doctorID AND AppointmentDate = '$appointmentDate' AND AppointmentTime = '$appointmentTime'";
        $resultCheck = $conn->query($sqlCheck);

        if ($resultCheck->num_rows > 0) {
            echo "<script>alert('The doctor already has an appointment at this time. Please choose a different time.');</script>";
        } else {
            // Insert the appointment into the database
            $sql = "INSERT INTO Appointments (DoctorID, PatientID, AppointmentDate, AppointmentTime, Status)
                    VALUES ($doctorID, $patientID, '$appointmentDate', '$appointmentTime', 'Pending')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Appointment created successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
    }
}

// Fetch available doctors
$sqlDoctors = "SELECT UserID, FirstName, LastName, Specialty FROM Users WHERE Role = 'Doctor'";
$resultDoctors = $conn->query($sqlDoctors);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment</title>
    <link rel="stylesheet" href="../style/appointment.css">
</head>
<body>
    <div class="container">
        <h1>Create an Appointment</h1>
        <form method="POST" action="appointments.php">
            <label for="doctor_id">Select Doctor:</label>
            <select id="doctor_id" name="doctor_id" required>
                <?php
                if ($resultDoctors->num_rows > 0) {
                    while ($row = $resultDoctors->fetch_assoc()) {
                        echo "<option value='" . $row['UserID'] . "'>Dr. " . $row['FirstName'] . " " . $row['LastName'] . " (" . $row['Specialty'] . ")</option>";
                    }
                } else {
                    echo "<option value=''>No doctors available</option>";
                }
                ?>
            </select>

            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required>

            <label for="appointment_time">Appointment Time:</label>
            <input type="time" id="appointment_time" name="appointment_time" required>

            <button type="submit" class="btn">Create Appointment</button>
        </form>
        <a href="patient.php" class="back-btn">Back to Profile</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
