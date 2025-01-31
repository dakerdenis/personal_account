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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <a href="#" class="tab-link" data-target="complaints">Mənim müraciyətlərim (Tibbi)</a>
                    <a href="#" class="tab-link" data-target="complaints_not_medical">Mənim müraciyətlərim (Qeyri-Tibbi)</a>
                    <a href="#" class="tab-link" data-target="refund">Geyriödəniş üçün müraciyət</a>
                </div>
                <form action="./vendor/logout.php" method="post">
                    <button type="submit">Çıxış</button>
                </form>
                <a target="_blank" class="whatsapp" href="https://wa.me/994502285753?text=Salam,%20Dərman%20çatdırılması%20haqqında%20məlumat%20ala%20bilərəmmi?">
                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    <p>Dərman çatdırılması</p>
                </a>

            </div>

            <div class="personal__account__data-wrapper">
                <div class="personal__account-desc">
                    Hörmətli <?php echo ($name . " " . $surname) ?>, <br>
                    A-Group şəxsi kabinetə xoş gəldiniz !
                </div>
                <!-- Tab content for various sections -->
                <div id="policies" class="tab-content">
                    Loading...
                </div>

                <!-----Policies info Auto---->
                <div id="policies__additional-auto" class="tab-content">

                </div>

                <!-----Policies info Medical---->
                <div id="policies__additional-medical" class="tab-content">

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

                <div id="complaints" class="tab-content">
                    Loading...
                </div>
                <div id="complaints_not_medical" class="tab-content">
                    <!-- Non-Medical Claims will be rendered here -->
                </div>


                <div id="refund" class="tab-content">

                </div>



                <div id="policy-popup" class="popup" style="display: none;">
                    <div id="policy-popup-content" class="popup-content">
                        <!-- Policy details will be rendered here -->
                    </div>
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
        <script src="./js/complaints.js"></script>
        <script src="./js/complaints_not_medical.js"></script>


    </body>

    </html>










