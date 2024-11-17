<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch medical test data
$sql = "SELECT TestName, TestPrice FROM MedicalTests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Tests</title>
    <link rel="stylesheet" href="../style/medical_test.css">
</head>
<body>
    <div class="container">
        <h1>Available Medical Tests</h1>
        <table>
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Price (BDT)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['TestName']) . "</td>
                                <td>" . htmlspecialchars($row['TestPrice']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No tests available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
