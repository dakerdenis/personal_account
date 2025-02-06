<?php
session_start();

function registerForDoctor($userName, $password, $pinCode, $cardNumber, $doctorId)
{
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx";

    // Extract the last portion of the card number (e.g., "100887/01")
    $matches = [];
    if (preg_match('/\d{6}\/\d{2}$/', $cardNumber, $matches)) {
        $formattedCardNumber = $matches[0];
    } else {
        // If the card number doesn't match the expected format, return an error
        echo json_encode(['success' => false, 'error' => 'Invalid card number format']);
        exit();
    }

    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<RegistrationForDoctor xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '<cardNumber>' . htmlspecialchars($formattedCardNumber) . '</cardNumber>' .
        '<customerId>' . htmlspecialchars($doctorId) . '</customerId>' .
        '</RegistrationForDoctor>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/RegistrationForDoctor\"",
        "Content-length: " . strlen($xml_post_string),
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    if ($response === false) {
        error_log("cURL error: " . curl_error($ch));
        echo json_encode(['success' => false, 'error' => curl_error($ch)]);
        curl_close($ch);
        exit();
    }

    curl_close($ch);

    // Log the SOAP response for debugging
    error_log("SOAP Response: $response");

    // Parse the SOAP response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['success' => false, 'error' => 'Failed to parse XML response']);
        exit();
    }

    // Extract the relevant data from the XML response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;

    // Extract the result
    $registrationResponse = $soapBody->children('http://tempuri.org/')->RegistrationForDoctorResponse;
    $registrationResult = (string)$registrationResponse->RegistrationForDoctorResult;

    // Parse the nested XML result inside <string>
    $innerXml = simplexml_load_string(html_entity_decode($registrationResult));
    if (!$innerXml) {
        echo json_encode(['success' => false, 'error' => 'Failed to parse inner XML response']);
        exit();
    }

    // Check for <SUCCESS>true</SUCCESS> in the parsed XML
    $success = (string)$innerXml->RESULT->SUCCESS;

    if ($success === 'true') {
        echo json_encode(['success' => true]); // Return success
    } else {
        echo json_encode(['success' => false]); // Return failure
    }
}

try {
    $userName = 'AQWeb';
    $password = '@QWeb';
    $pinCode = $_SESSION['pinCode'];
    $cardNumber = $_POST['cardNumber'];
    $doctorId = $_POST['doctorId'];

    // Debugging logs
    error_log("Registration inputs - PinCode: $pinCode, CardNumber: $cardNumber, DoctorId: $doctorId");

    registerForDoctor($userName, $password, $pinCode, $cardNumber, $doctorId);
} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
