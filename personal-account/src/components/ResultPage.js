import React, { useEffect, useState } from 'react';
import Cookies from 'js-cookie'; // For handling cookies
import './css/style.css'; // Import custom styles

function ResultPage() {
  const [customerInfo, setCustomerInfo] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    const pinCode = Cookies.get('pinCode'); // Get the stored pinCode from cookies

    if (pinCode) {
      // Make the request to the PHP API with the pinCode to get customer info
      fetch('https://a-group.az/cabinet/api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'getCustomerInfo', // Add action to differentiate this request
          username: 'AQWeb', // Replace with the actual username
          password: '@QWeb', // Replace with the actual password
          pinCode: pinCode,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          if (data.error) {
            setError(`API error: ${data.error}`);
          } else {
            setCustomerInfo(data.result); // Store the customer info
          }
        })
        .catch((err) => {
          setError(`Network error: ${err.message}`);
        });
    } else {
      setError('User not logged in. Please log in again.');
    }
  }, []);

  const handleLogout = () => {
    // Clear the session and cookies on logout
    localStorage.removeItem('loginSession');
    Cookies.remove('pinCode');
    window.location.href = '/cabinet/'; // Redirect to /cabinet on logout
  };

  return (
    <div className="result__container">
      <h1 className="result__title">Welcome to your Dashboard</h1>
      {error ? (
        <p className="error">{error}</p>
      ) : customerInfo ? (
        <div className="customer__info__container">
          <h2>Your Information:</h2>
          <pre className="customer__info">{customerInfo}</pre> {/* Display customer info */}
          <button className="logout__button" onClick={handleLogout}>
            Logout
          </button>
        </div>
      ) : (
        <p className="loading">Loading your information...</p>
      )}
    </div>
  );
}

export default ResultPage;
