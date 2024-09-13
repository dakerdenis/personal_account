<?php
header('Content-Type: application/json');

// Get the input JSON
$input = file_get_contents('php://input');
$formData = json_decode($input, true);

// Extract common form data
$username = $formData['username'];
$password = $formData['password'];
$pinCode = $formData['pinCode'];
$policyNumber = isset($formData['policyNumber']) ? $formData['policyNumber'] : null;
$phoneNumber = isset($formData['phoneNumber']) ? $formData['phoneNumber'] : null;
$action = isset($formData['action']) ? $formData['action'] : 'login'; // Default to login if no action provided

// SOAP login method
function login($username, $password, $pinCode, $policyNumber, $phoneNumber) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx";
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<Login xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($username) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '<policyNumber>' . htmlspecialchars($policyNumber) . '</policyNumber>' .
        '<phoneNumber>' . htmlspecialchars($phoneNumber) . '</phoneNumber>' .
        '</Login>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    return sendSoapRequest($soapUrl, $xml_post_string, 'Login');
}

// SOAP get customer information method
function getCustomerInformation($username, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx";
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetCustomerInformtaions xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($username) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '</GetCustomerInformtaions>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    return sendSoapRequest($soapUrl, $xml_post_string, 'GetCustomerInformtaions');
}

// Helper function to send the SOAP request
function sendSoapRequest($soapUrl, $xml_post_string, $soapAction) {
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/$soapAction\"",
        "Content-length: " . strlen($xml_post_string),
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification

    $response = curl_exec($ch);
    if ($response === false) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    return $response;
}

try {
    $response = login($username, $password, $pinCode, $policyNumber, $phoneNumber);
    $xml = simplexml_load_string($response);
    
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML', 'response' => $response]);
        exit;
    }

    // Check for error messages in the XML response
    $message = $xml->xpath('//MESSAGE');
    if ($message) {
        echo $xml->asXML(); // Return the error message as XML
        exit;
    }

    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $loginResult = $soapBody->children('http://tempuri.org/')->LoginResponse->LoginResult;
    
    echo json_encode(['name' => $loginResult->name, 'surname' => $loginResult->surname, 'result' => (string) $loginResult]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
