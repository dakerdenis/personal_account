import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom'; // For navigation
import './css/style.css'; // Styling
import company_logo from './css/assets/company_logo.svg';
import { loginUser } from './api/loginApi'; // Import the API call

function LoginForm() {
  const [formData, setFormData] = useState({
    username: 'AQWeb',
    password: '@QWeb',
    pinCode: 'A111111',
    policyNumber: 'MDC2400047-100887/01',
    phoneNumber: '994516704118'
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

  const showPopup = (message) => {
    setError(message);
    setTimeout(() => {
      setError(null);
    }, 2000); // Hide the error message after 2 seconds
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const result = await loginUser(formData); // Call the login API

      // If login is successful, navigate to the result page
      navigate('/result', { state: { result } });
    } catch (error) {
      showPopup('Incorrect login data, please try again.');
    }
  };

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
          <button type="submit">Daxil olmaq</button>
        </div>

        {error && <div className="popup">{error}</div>}
      </form>
    </div>
  );
}

export default LoginForm;
