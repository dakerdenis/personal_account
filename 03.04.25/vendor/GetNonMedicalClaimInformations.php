<?php
session_start();

header('Content-Type: application/json');

function getNonMedicalClaimInformations($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx";

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

    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetNonMedicalClaimInformations\"",
        "Content-length: " . strlen($xml_post_string),
    ];

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
    $pinCode = $_SESSION['pinCode'] ?? '';

    if (!$pinCode) {
        echo json_encode(['error' => 'PIN Code is missing']);
        exit();
    }

    $response = getNonMedicalClaimInformations($userName, $password, $pinCode);

    // Parse the SOAP response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse SOAP XML']);
        exit();
    }

    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $claimResponse = $soapBody->children('http://tempuri.org/')->GetNonMedicalClaimInformationsResponse;
    $claimResult = (string) $claimResponse->GetNonMedicalClaimInformationsResult;

    // Parse the inner XML
    $resultXml = simplexml_load_string(html_entity_decode($claimResult));
    if (!$resultXml || !$resultXml->DocumentElement->CLM_NOTICES) {
        echo json_encode([
            'CLM_NOTICE_DISPETCHER' => [],
            'debug' => $claimResult // Include raw response for debugging
        ]);
        exit();
    }

    // Convert the parsed XML data to an array
    $notices = $resultXml->DocumentElement->CLM_NOTICES;
    $complaints = [];
    foreach ($notices as $notice) {
        $complaints[] = [
            'PIN_CODE' => (string) $notice->PIN_CODE,
            'POLICY_NUMBER' => (string) $notice->POLICY_NUMBER,
            'INSURANCE_CODE' => (string) $notice->INSURANCE_CODE,
            'EVENT_OCCURRENCE_DATE' => (string) $notice->EVENT_OCCURRENCE_DATE,
            'STATUS_NAME' => (string) $notice->STATUS_NAME,
        ];
    }

    echo json_encode(['CLM_NOTICE_DISPETCHER' => $complaints]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Exception: ' . $e->getMessage()]);
}
