<?php
session_start(); // Start the session

// Check if the user is logged in and OTP has been verified
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['otp_pending'] === true) {
    // If not, redirect to login page
    header("Location: /cabinet/index.php");
    exit();
}

// Get user details from session
$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest';
$surname = isset($_SESSION['surname']) ? htmlspecialchars($_SESSION['surname']) : '';
$pinCode = isset($_SESSION['pinCode']) ? htmlspecialchars($_SESSION['pinCode']) : 'Unknown'; // Ensure pinCode is displayed
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Page</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>

    </style>
</head>

<body>

    <div class="personal__wrapper">
        <div class="perosnal__account__info">
            <h1>A-Group кабинет</h1>

            <form action="./vendor/logout.php" method="post">
                <button type="submit">Logout</button>
            </form>

            <div class="personal__account__info-additional">
                <a href="#" class="tab-link" data-target="policies">Мои полиса - список полисов</a>
                <a href="#" class="tab-link" data-target="doctors">Список врачей</a>
                <a href="#" class="tab-link" data-target="refund">Запрос на возврат средств</a>
            </div>
        </div>

        <div class="personal__account__data-wrapper">
            <div class="personal__account__data-lock">
                <h1>Добро пожаловать, <?php echo $name . ' ' . $surname; ?>!</h1>
                <p>Your PinCode: <?php echo $pinCode; ?></p>
            </div>

            <!-- Tab content for various sections -->
            <div id="policies" class="tab-content">
                <h2>Мои полиса</h2>
                <p>Список полисов здесь...</p>
            </div>

            <div id="doctors" class="tab-content">
                <!-- Specializations will be rendered here -->
            </div>

            <div id="specialists" class="tab-content">
    <!-- Specialists will be rendered here -->
</div>



            <div id="refund" class="tab-content">
                <h2>Запрос на возврат средств</h2>
                <p>Запрос на возврат средств здесь...</p>
            </div>
        </div>
    </div>

    <script src="./js/main.js"></script>
    <script src="./js/policies.js"></script>
    <script src="./js/doctors.js"></script>
    <script src="./js/refund.js"></script>
    <script src="./js/specialists.js"></script>



</body>

</html>