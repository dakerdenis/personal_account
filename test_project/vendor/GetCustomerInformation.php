<?php
session_start(); // Start the session

// SOAP request to fetch customer information
function getCustomerInformation($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    // Build the SOAP request XML
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetCustomerInformtaions xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '</GetCustomerInformtaions>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetCustomerInformtaions\"",
        "Content-length: " . strlen($xml_post_string),
    );

    // Initialize curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Execute curl and get response
    $response = curl_exec($ch);
    if ($response === false) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit();
    }
    curl_close($ch);

    return $response;
}

try {
    // Example: Replace with actual credentials
    $userName = 'AQWeb';
    $password = '@QWeb';
    $pinCode = $_SESSION['pinCode']; // Get the user's pinCode from the session

    // Fetch customer information
    $response = getCustomerInformation($userName, $password, $pinCode);

    // Parse the SOAP response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response.']);
        exit();
    }

    // Extract data from SOAP response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $customerInfoResponse = $soapBody->children('http://tempuri.org/')->GetCustomerInformtaionsResponse;
    $customerInfoResult = (string) $customerInfoResponse->GetCustomerInformtaionsResult;

    // Parse the inner XML
    $innerXml = simplexml_load_string(html_entity_decode($customerInfoResult));
    if (!$innerXml) {
        echo json_encode(['error' => 'Failed to parse inner XML.']);
        exit();
    }

    // Convert the parsed XML to a JSON-friendly structure
    $customerInfo = json_decode(json_encode($innerXml), true);

    // Check for expected structure
    if (!isset($customerInfo['CUSTOMER_INFORMATION']) || !isset($customerInfo['CARD_INFORMATION'])) {
        echo json_encode(['error' => 'Invalid customer data structure.']);
        exit();
    }

    // Return the data
    echo json_encode($customerInfo);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
