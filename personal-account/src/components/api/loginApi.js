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
      console.log("API Response Status:", response.status); // Log response status
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text(); // Expect text response (since it's XML wrapped)
    })
    .then((data) => {
      console.log("Raw Response from backend:", data); // Log the raw response from the backend
      resolve({ result: data }); // Resolve with the raw data
    })
    .catch((error) => {
      console.error("Network error:", error); // Log any network errors
      reject(`Network error: ${error.message}`);
    });
  });
};
