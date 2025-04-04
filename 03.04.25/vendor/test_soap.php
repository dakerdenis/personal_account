<?php
$soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx";

$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
    '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
    'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
    'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
    '<soap:Body>' .
    '<GetCustomerPolicies xmlns="http://tempuri.org/">' .
    '<userName>AQWeb</userName>' .
    '<password>@QWeb</password>' .
    '<pinCode>A222222</pinCode>' .
    '</GetCustomerPolicies>' .
    '</soap:Body>' .
    '</soap:Envelope>';

$headers = [
    "Content-Type: text/xml; charset=utf-8",
    "SOAPAction: \"http://tempuri.org/GetCustomerPolicies\"",
    "Content-Length: " . strlen($xml_post_string),
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
    echo "CURL Error: " . curl_error($ch);
} else {
    echo "Response: " . htmlspecialchars($response);
}
curl_close($ch);
