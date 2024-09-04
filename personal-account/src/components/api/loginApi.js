export const loginUser = async (formData) => {
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
  
    try {
        const response = await fetch('/api/insureazSvc/AQroupMobileIntegrationSvc.asmx', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/soap+xml; charset=utf-8',
              'SOAPAction': 'http://tempuri.org/Login',
            },
            body: soapRequest,
          });
          
          
  
      if (!response.ok) {
        throw new Error('Network response was not OK');
      }
  
      const responseText = await response.text();
      
      if (responseText.includes('<LoginResult>')) {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(responseText, 'text/xml');
        return xmlDoc.getElementsByTagName('LoginResult')[0].textContent;
      }
  
      throw new Error('Invalid login data');
    } catch (error) {
      console.error('Error:', error);
      throw error;
    }
  };
  