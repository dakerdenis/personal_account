<?php
session_start(); // Start the session

// Check if the user is logged in and phone number is available
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['phoneNumber'])) {
    header("Location: /cabinet/index.php");
    exit();
}

// SOAP request to generate OTP
function generateOtp($userName, $password, $phoneNumber) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<CreateOTPAndSendSMS xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<phoneNumber>' . htmlspecialchars($phoneNumber) . '</phoneNumber>' .
        '</CreateOTPAndSendSMS>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP Headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/CreateOTPAndSendSMS\"",
        "Content-length: " . strlen($xml_post_string),
    );

    // Initialize curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification if necessary
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL verification if necessary

    // Execute curl and get response
    $response = curl_exec($ch);
    if ($response === false) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit();
    }
    curl_close($ch);

    // Return the response
    return $response;
}

// Call the function to generate OTP and send it to the user
try {
    // Get the phone number from the session
    $phoneNumber = $_SESSION['phoneNumber'];

    // Replace with actual login credentials for OTP service
    $userName = 'AQWeb'; // API Username
    $password = '@QWeb'; // API Password

    // Generate OTP and send SMS
    $response = generateOtp($userName, $password, $phoneNumber);

    // Parse the response XML to extract the OTP code
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response.']);
        exit();
    }

    // Extract OTP code from the response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $otpResponse = $soapBody->children('http://tempuri.org/')->CreateOTPAndSendSMSResponse;
    $otpResult = (string)$otpResponse->CreateOTPAndSendSMSResult;

    // Extract the OTP code from the response
    $resultXml = simplexml_load_string(html_entity_decode($otpResult));
    $otpCode = (string)$resultXml->OTP->Code;
    $otpStatus = (string)$resultXml->OTP->Result;

    // Check if OTP generation was successful
    if ($otpStatus == 'OK') {
        // Store the OTP in the session for verification
        $_SESSION['otp'] = $otpCode;

        // Temporarily echo the OTP for debugging (REMOVE THIS IN PRODUCTION)
        echo json_encode(['success' => true, 'otp' => $otpCode]); // Debugging: echo OTP code
    } else {
        echo json_encode(['error' => 'Failed to generate OTP.']);
    }

    // Redirect to verification page
    header("Location: /cabinet/vendor/verification.php");
    exit();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
