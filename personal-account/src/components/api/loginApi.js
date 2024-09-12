export const loginUser = (formData) => {
  const soapRequest = `<?xml version="1.0" encoding="utf-8"?>
    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
      <soap12:Body>
        <Login xmlns="http://tempuri.org/">
          <userName>${formData.username}</userName>
          <password>${formData.password}</password>
          <pinCode>${formData.pinCode}</pinCode>
          <policyNumber>${formData.policyNumber}</policyNumber>
          <phoneNumber>${formData.phoneNumber}</phoneNumber>
        </Login>
      </soap12:Body>
    </soap12:Envelope>`;

  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx', true);


    // Set the appropriate headers
  // xhr.setRequestHeader('Content-Type', 'application/soap+xml; charset=utf-8');
  // xhr.setRequestHeader('SOAPAction', 'http://tempuri.org/Login');

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) { // When the request is complete
        if (xhr.status === 200) {
          const responseText = xhr.responseText;

          if (responseText.includes('<LoginResult>')) {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(responseText, 'text/xml');
            resolve(xmlDoc.getElementsByTagName('LoginResult')[0].textContent);
          } else {
            reject('Invalid login data');
          }
        } else {
          reject(`Network error: ${xhr.statusText}`);
        }
      }
    };

    // Handle request errors
    xhr.onerror = function () {
      reject('Request failed');
    };

    // Send the SOAP request
    xhr.send(soapRequest);
  });
};
