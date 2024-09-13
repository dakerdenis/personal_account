export const loginUser = (formData) => {
  return new Promise((resolve, reject) => {
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
      return response.text(); // Expect the PHP script to return XML
    })
    .then((data) => {
      resolve(data); // Resolve with the XML response
    })
    .catch((error) => {
      reject(`Network error: ${error.message}`);
    });
  });
};
