    <?php
    session_start(); // Start the session

    // Check if the user is logged in and OTP has been verified
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['otp_pending'] === true) {
        // If not, redirect to login page
        header("Location: /cabinet/$2OpzQ3jR0%5E=/index.php");
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
                <h1>A-Qroup sığorta şirkəti <br> şəxsi kabinet</h1>



                <div class="personal__account__info-additional">
                    <a href="#" class="tab-link" data-target="policies">Şəhadətnamələr</a>
                    <a href="#" class="tab-link" data-target="doctors">Həkimlər siyahısı</a>
                    <a href="#" class="tab-link" data-target="complaints">Mənim müraciətlərim (Tibbi)</a>
                    <a href="#" class="tab-link" data-target="complaints_not_medical">Mənim müraciətlərim
                        (Qeyri-Tibbi)</a>
                    <a href="#" class="tab-link" data-target="refund">Geri ödəniş üçün müraciət</a>
                    <!---a href="https://a-group.az/payments/" target="_blank"  class="tab-link">Onlayn Ödəniş</a-->
                </div>
                <?php
                if (isset($_SESSION['medical_policies']) && !empty($_SESSION['medical_policies'])) {
                    echo "<div class='medical-policies-list'>";
                    echo "<h4>Active Medical Policies:</h4><ul>";
                    foreach ($_SESSION['medical_policies'] as $policyNumber) {
                        echo "<li>$policyNumber</li>";
                    }
                    echo "</ul></div>";
                }
                ?>

                <form action="./vendor/logout.php" method="post">
                    <button type="submit">Çıxış</button>
                </form>
                <a target="_blank" class="whatsapp"
                    href="https://wa.me/994502285753?text=Salam,%20Dərman%20çatdırılması%20haqqında%20məlumat%20ala%20bilərəmmi?">
                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    <p>Dərman çatdırılması</p>
                </a>

            </div>

            <div class="personal__account__data-wrapper">
                <div class="personal__account-desc">
                    Hörmətli <?php echo ($name . " " . $surname) ?>, <br>
                    şəxsi kabinetə xoş gəlmişsiniz!
                </div>
                <!-- Tab content for various sections -->
                <div id="policies" class="tab-content">
                    
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

                <div id="doctor-popup" class="popup" style="display: none;">

                    <div class="doctor-popup__wrapper">
                        <button id="close-doctor-popup" class="popup-close">Bağlamaq</button>
                        <div id="doctor-popup-content" class="popup-content2">

                            <!-- Doctor details will be rendered here -->
                        </div>
                    </div>


                </div>


            </div>

        </div>


        <div id="preloader" class="preloader" style="display: none;">
            <div class="loader"></div>
        </div>


        <script src="./js/main.js"></script>
        <script src="./js/policies.js"></script>
        <script src="./js/doctors.js"></script>
        <script src="./js/refund.js"></script>
        <script src="./js/specialists.js"></script>
        <script src="./js/doctorDetails.js"></script>
        <script src="./js/complaints.js"></script>
        <script src="./js/complaints_not_medical.js"></script>
        <script src="./js/registerDoctorPopup.js"></script>


    </body>

    </html>