<?php
session_start(); // Start the session

// SOAP request to fetch non-medical claim information
function getNonMedicalClaimInformations($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    // Build the SOAP request XML
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetNonMedicalClaimInformations xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '</GetNonMedicalClaimInformations>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetNonMedicalClaimInformations\"",
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

    // Return the SOAP response
    return $response;
}

try {
    // Example: Replace with actual credentials
    $userName = 'AQWeb'; // Replace with your actual API username
    $password = '@QWeb'; // Replace with your actual API password
    $pinCode = $_SESSION['pinCode']; // Get the user's pinCode from the session

    // Call the SOAP function to get non-medical claim information
    $response = getNonMedicalClaimInformations($userName, $password, $pinCode);

    // Parse the response XML
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response']);
        exit();
    }

    // Extract the relevant data from the SOAP response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $claimResponse = $soapBody->children('http://tempuri.org/')->GetNonMedicalClaimInformationsResponse;
    $claimResult = (string)$claimResponse->GetNonMedicalClaimInformationsResult;

    // Decode the result into an XML structure
    $resultXml = simplexml_load_string(html_entity_decode($claimResult));
    if (!$resultXml || !$resultXml->CLM_NOTICE_DISPETCHER) { // Check if CLM_NOTICE_DISPETCHER element exists
        echo json_encode(['error' => 'Invalid non-medical claims result']);
        exit();
    }

    // Convert the result to a JSON-friendly structure
    $claims = json_decode(json_encode($resultXml), true);

    // Return the claims as a JSON response
    echo json_encode(['CLM_NOTICE_DISPETCHER' => $claims['CLM_NOTICE_DISPETCHER']]); // Adjust to send only relevant data

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
