<?php
ob_start();  // Start output buffering to ensure no output before header()
session_start();
include 'db.php';


// Check if the admin is logged in
if (!isset($_SESSION['Is_Admin']) || $_SESSION['Is_Admin'] !== 1) {
    header('Location: signin.php'); // Redirect to login page if not an admin
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Departure_Date = trim($_POST['Departure_Date']);
    $Arrival_Date = trim($_POST['Arrival_Date']);
    $Origin = trim($_POST['Origin']);
    $Destination = trim($_POST['Destination']);
    $Departure_Time = trim(string: $_POST['Departure_Time']);
    $Arrival_Time = trim($_POST['Arrival_Time']);
    $Amount = trim($_POST['Amount']);

    $sql = "INSERT INTO Available_Flights (Departure_Date, Arrival_Date, Origin, Destination, Departure_Time, Arrival_Time, Amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Bind the parameters to the query
    $stmt->bind_param("sssssss", $Departure_Date, $Arrival_Date, $Origin, $Destination, $Departure_Time, $Arrival_Time, $Amount);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Flight created successfully!";
        header("Location: see_flights.php"); // Redirect to sign-in page after successful registration
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <a href="logout.php">Logout</a> <!-- Show Logout if logged in -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link rel="stylesheet" href="/ANGEL/styles/admin_add_flights.css">
</head>
<body>
    <h1>Welcome Admin!</h1>
            <a href="admin.php">Home</a>

    <h2>Add Flight</h2>
    <form method="POST">
        <label>Departure_Date:</label><br>
        <input type="date" name="Departure_Date" required><br>
        
        <label>Arrival_Date:</label><br>
        <input type="date" name="Arrival_Date" required><br>
        
        <label>Origin:</label><br>
        <input type="text" name="Origin" required><br>
        
        <label>Destination:</label><br>
        <input type="text" name="Destination" required><br>
        
        <label>Departure_Time:</label><br>
        <input type="time" name="Departure_Time" required><br>
        
        <label>Arrival_Time:</label><br>
        <input type="time" name="Arrival_Time" required><br>

        <label>Amount:</label><br>
        <input type="decimal" name="Amount" required><br>
        
        <button type="submit">Add Flight</button>
    </form>
    <h2> </h2>
</body>
</html>

