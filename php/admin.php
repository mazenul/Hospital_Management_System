<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "hospital"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Blood Unit
if (isset($_POST['add_blood'])) {
    $blood_type = $_POST['blood_type'];
    $units = $_POST['units'];
    $cost = $_POST['cost'];
    $conn->query("INSERT INTO BloodBank (BloodType, UnitsAvailable, CostPerUnit) VALUES ('$blood_type', '$units', '$cost')");
}

// Update Blood Units
if (isset($_POST['update_blood_units'])) {
    $blood_id = $_POST['blood_id'];
    $new_units = $_POST['new_units'];
    $conn->query("UPDATE BloodBank SET UnitsAvailable = '$new_units' WHERE BloodID = '$blood_id'");
}

// Add Medical Test
if (isset($_POST['add_test'])) {
    $test_name = $_POST['test_name'];
    $test_price = $_POST['test_price'];
    $conn->query("INSERT INTO MedicalTests (TestName, TestPrice) VALUES ('$test_name', '$test_price')");
}

// Update Medical Test Price
if (isset($_POST['update_test_price'])) {
    $test_id = $_POST['test_id'];
    $new_price = $_POST['new_price'];
    $conn->query("UPDATE MedicalTests SET TestPrice = '$new_price' WHERE TestID = '$test_id'");
}

// Delete User
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $conn->query("DELETE FROM Users WHERE UserID = '$user_id'");
}

// Delete Medical Test
if (isset($_POST['delete_test'])) {
    $test_id = $_POST['test_id'];
    $conn->query("DELETE FROM MedicalTests WHERE TestID = '$test_id'");
}

// Delete Blood Group
if (isset($_POST['delete_blood'])) {
    $blood_id = $_POST['blood_id'];
    $conn->query("DELETE FROM BloodBank WHERE BloodID = '$blood_id'");
}


// View Data
$doctors = $conn->query("SELECT * FROM Users WHERE Role = 'Doctor'");
$patients = $conn->query("SELECT * FROM Users WHERE Role = 'Patient'");
$bloodbank = $conn->query("SELECT * FROM BloodBank");
$tests = $conn->query("SELECT * FROM MedicalTests");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="../style/admin.css">
    <script>
        function searchTable(inputId, tableId) {
            const input = document.getElementById(inputId).value.toUpperCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toUpperCase().includes(input)) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? "" : "none";
            }
        }
    </script>
</head>
<body>
    
    <div class="admin-container">
        <div id="logout">
        <form action="../php/logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
        <h1>Admin Control Panel</h1>

        <!-- Doctor Management -->
        <section class="admin-section">
            <h2>Manage Doctors</h2>
            <input type="text" id="searchDoctors" placeholder="Search Doctors..." onkeyup="searchTable('searchDoctors', 'doctorTable')">
            <table id="doctorTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($doctor = $doctors->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $doctor['UserID'] ?></td>
                            <td><?= $doctor['FirstName'] . " " . $doctor['LastName'] ?></td>
                            <td><?= $doctor['Specialty'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="user_id" value="<?= $doctor['UserID'] ?>">
                                    <button type="submit" name="delete_user">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <!-- Patient Management -->
        <section class="admin-section">
            <h2>Manage Patients</h2>
            <input type="text" id="searchPatients" placeholder="Search Patients..." onkeyup="searchTable('searchPatients', 'patientTable')">
            <table id="patientTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($patient = $patients->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $patient['UserID'] ?></td>
                            <td><?= $patient['FirstName'] . " " . $patient['LastName'] ?></td>
                            <td><?= $patient['Gender'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="user_id" value="<?= $patient['UserID'] ?>">
                                    <button type="submit" name="delete_user">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <!-- Blood Bank Management -->
        <section class="admin-section">
            <h2>Manage Blood Bank</h2>
            <table>
                <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Units Available</th>
                        <th>Cost Per Unit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($blood = $bloodbank->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $blood['BloodType'] ?></td>
                            <td><?= $blood['UnitsAvailable'] ?></td>
                            <td><?= $blood['CostPerUnit'] ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="blood_id" value="<?= $blood['BloodID'] ?>">
                                    <input type="number" name="new_units" placeholder="New Units" required>
                                    <button type="submit" name="update_blood_units">Update</button>
                                </form>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="blood_id" value="<?= $blood['BloodID'] ?>">
                                    <button type="submit" name="delete_blood">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form method="post" class="add-form">
                <input type="text" name="blood_type" placeholder="Blood Type" required>
                <input type="number" name="units" placeholder="Units Available" required>
                <input type="number" name="cost" placeholder="Cost Per Unit" required>
                <button type="submit" name="add_blood">Add Blood</button>
            </form>
        </section>


        <!-- Medical Test Management -->
        <section class="admin-section">
            <h2>Manage Medical Tests</h2>
            <input type="text" id="searchTests" placeholder="Search Medical Tests..." onkeyup="searchTable('searchTests', 'testTable')">
            <table id="testTable">
                <thead>
                    <tr>
                        <th>Test ID</th>
                        <th>Test Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($test = $tests->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $test['TestID'] ?></td>
                            <td><?= $test['TestName'] ?></td>
                            <td><?= $test['TestPrice'] ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="test_id" value="<?= $test['TestID'] ?>">
                                    <button type="submit" name="delete_test">Delete</button>
                                </form>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="test_id" value="<?= $test['TestID'] ?>">
                                    <input type="number" name="new_price" placeholder="New Price" required>
                                    <button type="submit" name="update_test_price">Update Price</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form method="post" class="add-form">
                <input type="text" name="test_name" placeholder="Test Name" required>
                <input type="number" name="test_price" placeholder="Price" required>
                <button type="submit" name="add_test">Add Test</button>
            </form>
        </section>
    </div>
</body>
</html>
