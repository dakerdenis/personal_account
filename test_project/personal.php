<?php
session_start(); // Start the session

// Debugging session values (remove this after checking)
var_dump($_SESSION); // Check session values
exit();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not, redirect to login page
    header("Location: /cabinet/index.php");
    exit();
}

// Get the user's name, surname, and pinCode from the session
$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest';
$surname = isset($_SESSION['surname']) ? htmlspecialchars($_SESSION['surname']) : '';
$pinCode = isset($_SESSION['pinCode']) ? htmlspecialchars($_SESSION['pinCode']) : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $name . ' ' . $surname; ?>!</h1>
    <p>Your PinCode: <?php echo $pinCode; ?></p>
    <p>This is your personal page.</p>

    <!-- Logout button -->
    <form action="./vendor/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
