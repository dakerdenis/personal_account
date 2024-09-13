import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom'; // For navigation
import './css/style.css'; // Styling
import company_logo from './css/assets/company_logo.svg';
import { loginUser } from './api/loginApi'; // Import the API call
import Cookies from 'js-cookie'; // For handling cookies

function LoginForm() {
  const [formData, setFormData] = useState({
    username: 'AQWeb',
    password: '@QWeb',
    pinCode: '',
    policyNumber: '',
    phoneNumber: '',
  });

  const [error, setError] = useState(null);
  const navigate = useNavigate(); // React Router's hook to navigate between components

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
      const result = await loginUser(formData); // Call the login API

      // Check for error messages in the response from the API
      if (result && result.includes('<MESSAGE>')) {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(result, 'text/xml');
        const errorMessage = xmlDoc.getElementsByTagName('MESSAGE')[0]?.textContent;

        // Handle specific error messages
        if (errorMessage === 'incorrect_phone_number' || errorMessage === 'repeated_phone_number' || errorMessage === 'user_not_found') {
          setError(`Error: ${errorMessage.replace('_', ' ')}`);
          return;
        }
      }

      // If the response contains valid name and surname, proceed to result page
      if (result && result.name && result.surname) {
        // Store login information in localStorage with a 1-hour expiry
        const expiryTime = Date.now() + 3600000; // 1 hour in milliseconds
        localStorage.setItem('loginSession', JSON.stringify({ result, expiryTime }));

        // Store the pinCode in cookies for further API requests
        Cookies.set('pinCode', formData.pinCode, { expires: 1 / 24 }); // Cookie valid for 1 hour

        // Navigate to the result page if successful login
        navigate('/result', { state: { result } });
      } else {
        setError('Unexpected error occurred. Please try again.');
      }
    } catch (error) {
      setError('Incorrect login data, please try again.');
    }
  };

  // Check session expiration
  useEffect(() => {
    const session = JSON.parse(localStorage.getItem('loginSession'));
    if (session && session.expiryTime > Date.now()) {
      navigate('/result', { state: { result: session.result } });
    }
  }, [navigate]);

  return (
    <div className="login__container">
      <form onSubmit={handleSubmit} className="form__container">
        <div className="form__image">
          <img src={company_logo} alt="Company Logo" />
        </div>

        <div className="form__input__container">
          <p className="form__input__desc">UserName:</p>
          <input
            type="text"
            name="username"
            id="username"
            value={formData.username}
            onChange={handleChange}
          />
        </div>

        <div className="form__input__container">
          <p className="form__input__desc">Password:</p>
          <input
            type="password"
            name="password"
            id="password"
            value={formData.password}
            onChange={handleChange}
          />
        </div>

        <div className="form__input__container">
          <p className="form__input__desc">PinCode:</p>
          <input
            type="text"
            name="pinCode"
            id="pinCode"
            value={formData.pinCode}
            onChange={handleChange}
          />
        </div>

        <div className="form__input__container">
          <p className="form__input__desc">PolicyNumber:</p>
          <input
            type="text"
            name="policyNumber"
            id="policyNumber"
            value={formData.policyNumber}
            onChange={handleChange}
          />
        </div>

        <div className="form__input__container">
          <p className="form__input__desc">PhoneNumber:</p>
          <input
            type="text"
            name="phoneNumber"
            id="phoneNumber"
            value={formData.phoneNumber}
            onChange={handleChange}
          />
        </div>

        <div className="form__input__button">
          <button type="submit">Login</button>
        </div>

        {error && <div className="popup">{error}</div>}
      </form>
    </div>
  );
}

export default LoginForm;
