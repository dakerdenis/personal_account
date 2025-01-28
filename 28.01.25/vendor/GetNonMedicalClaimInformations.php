<?php
session_start(); // Start the session

function getNonMedicalClaimInformations($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx";

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
    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetNonMedicalClaimInformations\"",
        "Content-length: " . strlen($xml_post_string),
    ];

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
    $userName = 'AQWeb'; 
    $password = '@QWeb'; 
    $pinCode = $_SESSION['pinCode'];

    $response = getNonMedicalClaimInformations($userName, $password, $pinCode);

    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response']);
        exit();
    }

    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $claimResponse = $soapBody->children('http://tempuri.org/')->GetNonMedicalClaimInformationsResponse;
    $claimResult = (string) $claimResponse->GetNonMedicalClaimInformationsResult;

    $resultXml = simplexml_load_string(html_entity_decode($claimResult));
    if (!$resultXml || !$resultXml->CLM_NOTICE_DISPETCHER) {
        echo json_encode(['CLM_NOTICE_DISPETCHER' => []]); // Return empty array for no data
        exit();
    }

    $claims = json_decode(json_encode($resultXml), true);

    echo json_encode(['CLM_NOTICE_DISPETCHER' => $claims['CLM_NOTICE_DISPETCHER']]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
