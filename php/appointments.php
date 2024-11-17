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

    $sql = "INSERT INTO Appointments (DoctorID, PatientID, AppointmentDate, AppointmentTime, Status)
            VALUES ($doctorID, $patientID, '$appointmentDate', '$appointmentTime', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Appointment created successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
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
