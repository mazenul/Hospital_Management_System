<?php
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
        echo'<br><br>';
    }
    // Add a button to navigate to appointment creation page
    echo '<a href="appointments.php">Create Appointment</a>';

    

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

    // Fetch and display individual bills
    echo "<h3>Bills</h3>";
    $sql = "SELECT Bills.BillID, Bills.Amount, Bills.PaymentStatus, MedicalTests.TestName
            FROM Bills
            LEFT JOIN MedicalTests ON Bills.TestID = MedicalTests.TestID
            WHERE Bills.PatientID = $patientID";
    $result = $conn->query($sql);

    $totalAmount = 0; // To calculate the total bill

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Test Name</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['TestName'] . "</td>
                    <td>$" . $row['Amount'] . "</td>
                    <td>" . $row['PaymentStatus'] . "</td>
                </tr>";
            if ($row['PaymentStatus'] === 'Unpaid') {
                $totalAmount += $row['Amount'];
            }
        }
        echo "</table>";
    } else {
        echo "No bills found.";
    }

    // Display total bill amount
    echo "<h4>Total Amount Due: $" . $totalAmount . "</h4>";

    // Add a Reset Button
    if ($totalAmount > 0) {
        echo '<form action="../php/reset_bill.php" method="POST">
            <button type="submit">Pay Bill</button>
          </form>';
    }


    // Add new medical test form
    echo '<h3>Add Medical Test</h3>';
    echo '<form action="../php/add_medical_test.php" method="POST">
            <label for="testID">Select Test:</label>
            <select name="testID" required>';

    $sql = "SELECT TestID, TestName FROM MedicalTests";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['TestID'] . '">' . $row['TestName'] . '</option>';
        }
    }
    echo '</select>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <button type="submit">Add Test</button>
          </form>';
} else {
    echo "Unauthorized access.";
}
$conn->close();
