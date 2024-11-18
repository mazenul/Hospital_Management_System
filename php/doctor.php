<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="../style/doctor.css">
</head>
<body>
    <div class="container">
        <h1>Doctor Dashboard</h1>
        <section id="info">
            <?php include '../php/doctor_info.php'; ?>
        </section>
        <form action="../php/clear_appointments.php" method="POST">
            <button type="submit">Clear All Appointments</button>
        </form>
        <form action="../php/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
