export const loginUser = (formData) => {
  return new Promise((resolve, reject) => {
    // Step 1: Make a request to the PHP proxy (not directly to the SOAP service)
    fetch('https://a-group.az/cabinet/api.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(formData), // Send form data as JSON
    })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json(); // Expect the PHP script to return JSON
    })
    .then((data) => {
      if (data.error) {
        reject(`API error: ${data.error}`);
      } else {
        resolve(data); // Resolve with the data received from the PHP proxy
      }
    })
    .catch((error) => {
      reject(`Network error: ${error.message}`);
    });
  });
};
