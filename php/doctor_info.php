<?php
session_start();
include 'connect.php';

if (isset($_SESSION['UserID']) && $_SESSION['Role'] == 'Doctor') {
    $doctorID = $_SESSION['UserID'];

    // Fetch doctor's information
    $sql = "SELECT * FROM Users WHERE UserID = $doctorID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Doctor Information</h2>";
        echo "Name: " . $row['FirstName'] . " " . $row['LastName'] . "<br>";
        echo "Specialty: " . $row['Specialty'] . "<br>";
        echo "Date of Birth: " . $row['DOB'] . "<br>";
        echo "Gender: " . $row['Gender'] . "<br>";
        echo "Address: " . $row['Address'] . "<br>";
        echo "Phone: " . $row['Phone'] . "<br>";
        echo "Email: " . $row['Email'] . "<br>";
    } else {
        echo "<p>No doctor information found.</p>";
    }

    // Fetch and display appointments
    echo "<h3>Appointments</h3>";
    $sql = "SELECT A.AppointmentDate, A.AppointmentTime, U.FirstName AS PatientFirstName, U.LastName AS PatientLastName
            FROM Appointments A
            JOIN Users U ON A.PatientID = U.UserID
            WHERE A.DoctorID = $doctorID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Patient Name: " . $row['PatientFirstName'] . " " . $row['PatientLastName'] . "<br>";
            echo "Date: " . $row['AppointmentDate'] . ", Time: " . $row['AppointmentTime'] . "<br><br>";
        }
    } else {
        echo "<p>No appointments found.</p>";
    }
} else {
    echo "<p>Unauthorized access.</p>";
}

$conn->close();
