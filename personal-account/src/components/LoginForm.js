import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';
import LoginFormUI from './LoginFormUI'; // Import the UI component
import { loginUser } from './api/loginApi'; // Import the API call

function LoginForm() {
  const [formData, setFormData] = useState({
    username: 'AQWeb',
    password: '@QWeb',
    pinCode: 'A111111',
    policyNumber: 'MDC2400047-100887/01',
    phoneNumber: '994516704118',
  });

  const [error, setError] = useState(null);
  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
        console.log("Form Data being submitted:", formData); // Log the form data

        const result = await loginUser(formData); // Call the login API

        // Log the raw result for debugging
        console.log("API Raw Response:", result);

        // Check for error message in JSON response
        if (result.error) {
            console.log("API Error Received:", result.error); // Log the error from the API
            setError(result.error);  // Display error message
            return;
        }

        // Parse the result XML to extract name, surname, and login status
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(result.result, 'text/xml');
        
        console.log("Parsed XML:", xmlDoc); // Log the parsed XML

        // Get the relevant data from the XML response
        const isLogged = xmlDoc.getElementsByTagName('IS_LOGGED')[0]?.textContent;
        const name = xmlDoc.getElementsByTagName('NAME')[0]?.textContent;
        const surname = xmlDoc.getElementsByTagName('SURNAME')[0]?.textContent;

        console.log("Parsed XML Response:", { isLogged, name, surname });

        // Handle login result
        if (isLogged === '1' && name && surname) {
            const expiryTime = Date.now() + 3600000; // 1 hour in milliseconds
            localStorage.setItem('loginSession', JSON.stringify({ result, expiryTime }));
            Cookies.set('pinCode', formData.pinCode, { expires: 1 / 24 });
            navigate('/cabinet/result', { state: { name, surname } });
        } else {
            setError('Invalid PinCode, Policy Number, or Mobile Number.');
        }
    } catch (error) {
        console.error("Error during login:", error); // Log the error
        setError('Incorrect login data, please try again.');
    }
};


  // Check session expiration
  useEffect(() => {
    const session = JSON.parse(localStorage.getItem('loginSession'));
    if (session && session.expiryTime > Date.now()) {
      const parser = new DOMParser();
      const xmlDoc = parser.parseFromString(session.result, 'text/xml');
      const name = xmlDoc.getElementsByTagName('NAME')[0]?.textContent;
      const surname = xmlDoc.getElementsByTagName('SURNAME')[0]?.textContent;
      navigate('/cabinet/result', { state: { name, surname } });
    }
  }, [navigate]);

  return (
    <LoginFormUI
      formData={formData}
      handleChange={handleChange}
      handleSubmit={handleSubmit}
      error={error}
    />
  );
}

export default LoginForm;
