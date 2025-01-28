<?php
session_start();

// SOAP request to fetch customer information
function getCustomerInformation($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx";

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

    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetCustomerInformtaions\"",
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

    $response = getCustomerInformation($userName, $password, $pinCode);

    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response']);
        exit();
    }

    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $customerInfoResponse = $soapBody->children('http://tempuri.org/')->GetCustomerInformtaionsResponse;
    $customerInfoResult = (string)$customerInfoResponse->GetCustomerInformtaionsResult;

    $innerXml = simplexml_load_string(html_entity_decode($customerInfoResult));
    if (!$innerXml) {
        echo json_encode(['error' => 'Failed to parse inner XML']);
        exit();
    }

    $customerInfo = json_decode(json_encode($innerXml), true);

    if (!isset($customerInfo['CUSTOMER_INFORMATION']) || !isset($customerInfo['CARD_INFORMATION'])) {
        echo json_encode(['error' => 'Invalid customer data structure']);
        exit();
    }

    // Check for medical policy
    $medicalPolicy = null;
    if (isset($customerInfo['CARD_INFORMATION'])) {
        $policies = $customerInfo['CARD_INFORMATION'];
        foreach ($policies as $policy) {
            if ($policy['INSURANCE_NAME'] === 'Tibbi sığorta') {
                $medicalPolicy = $policy['CARD_NUMBER'];
                break;
            }
        }
    }

    if ($medicalPolicy) {
        $_SESSION['medicalPolicyNumber'] = $medicalPolicy; // Cache the policy number in the session
    }

    echo json_encode($customerInfo);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
