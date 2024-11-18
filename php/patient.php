<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../style/patient.css">

    
</head>
<body>
    <div class="container">
        <h1>Patient Dashboard</h1>
        <section id="info">
            <?php include '../php/patient_info.php'; ?>
        </section>
        <br><br><form action="../php/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
