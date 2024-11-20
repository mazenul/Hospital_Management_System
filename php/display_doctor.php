<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "hospital"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctor details
$sql = "SELECT FirstName, LastName, Specialty FROM Users WHERE Role = 'Doctor'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>
    <link rel="stylesheet" href="../style/display_doctor.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="container">
        <h1>Our Doctors</h1>
        <div class="doctor-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="doctor-card">';
                    echo '<h2>' . htmlspecialchars($row['FirstName']) . ' ' . htmlspecialchars($row['LastName']) . '</h2>';
                    echo '<p>Specialization: ' . htmlspecialchars($row['Specialty']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No doctors available at the moment.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
