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
        <title>A-Group Şəxsi kabinet</title>
        <link rel="stylesheet" href="./style/style.css">
    </head>

    <body>

        <div class="personal__wrapper">
            <div class="perosnal__account__info">
                <div class="personal__account_image">
                    <img src="https://a-group.az/storage/uploaded_files/Z6zB/company_logo.png" alt="" srcset="">
                </div>
                <h1>A-Group şəxsi kabinetə xoş gəlmisiniz !</h1>



                <div class="personal__account__info-additional">
                    <a href="#" class="tab-link" data-target="policies">Şəhadətləmələr</a>
                    <a href="#" class="tab-link" data-target="doctors">Həkimlər siyahısı</a>
                    <a href="#" class="tab-link" data-target="refund">Geyriödəniş üçün müraciyət</a>
                </div>
                <form action="./vendor/logout.php" method="post">
                    <button type="submit">Çıxış</button>
                </form>
            </div>

            <div class="personal__account__data-wrapper">
                <div class="personal__account-desc">
                    Hörmətli <?php echo ($name . " " . $surname) ?> A-Group şəxsi kabinetə xoş gəldiniz !
                </div>
                <!-- Tab content for various sections -->
                <div id="policies" class="tab-content">
                    Ebanat
                </div>

                <div id="doctors" class="tab-content">
                    <!-- Specializations will be rendered here -->
                </div>

                <div id="specialists" class="tab-content">
                    <!-- Specialists will be rendered here -->
                </div>

                <div id="doctor-details" class="tab-content">
                    <!-- Doctor details will be rendered here -->
                </div>



                <div id="refund" class="tab-content">

                </div>
            </div>

        </div>


        <div id="preloader" class="preloader" style="display: none;">
            <div class="loader"></div>
            <p>Loading...</p>
        </div>


        <script src="./js/main.js"></script>
        <script src="./js/policies.js"></script>
        <script src="./js/doctors.js"></script>
        <script src="./js/refund.js"></script>
        <script src="./js/specialists.js"></script>



    </body>

    </html>