<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "hospital";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

include "connect.php";

// Handle form submission for buying or donating blood
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bloodType = $_POST["bloodType"];
    $action = $_POST["action"];
    $units = intval($_POST["units"]);

    if ($action == "buy") {
        $sql = "UPDATE BloodBank SET UnitsAvailable = UnitsAvailable - $units WHERE BloodType = '$bloodType'";
    } else {
        $sql = "UPDATE BloodBank SET UnitsAvailable = UnitsAvailable + $units WHERE BloodType = '$bloodType'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Transaction successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch blood bank data
$sql = "SELECT BloodType, UnitsAvailable, CostPerUnit FROM BloodBank";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Bank Management</title>
    <link rel="stylesheet" type="text/css" href="../style/bloodbank.css">
</head>
<body>
<br><br><br><br>
<h2>Blood Bank Management</h2>

<table>
    <tr>
        <th>Blood Group</th>
        <th>Unit Price</th>
        <th>Available Units</th>
    </tr>
    <?php if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row["BloodType"]; ?></td>
        <td><?php echo $row["CostPerUnit"]; ?></td>
        <td><?php echo $row["UnitsAvailable"]; ?></td>
    </tr>
    <?php } } else { ?>
    <tr>
        <td colspan="3">No data available</td>
    </tr>
    <?php } ?>
</table>

<form method="post" action="bloodbank.php">
    <label for="bloodType">Blood Group:</label>
    <select id="bloodType" name="bloodType" required>
        <option value="A+">A+</option>
        <option value="O+">O+</option>
        <option value="B+">B+</option>
        <option value="AB+">AB+</option>
    </select>
    <label for="units">Units:</label>
    <input type="number" id="units" name="units" required>
    <label for="action">Action:</label>
    <select id="action" name="action" required>
        <option value="buy">Buy</option>
        <option value="donate">Donate</option>
    </select>
    <input type="submit" value="Submit">
</form>

<div>
    <button id = "back"><a href="../Pages/index.html">Back </a></button>
</div>

</body>
</html>
