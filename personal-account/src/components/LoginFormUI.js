import React from 'react';
import './css/style.css'; // Styling
import company_logo from './css/assets/company_logo.svg'; // Company logo

function LoginFormUI({ formData, handleChange, handleSubmit, error }) {
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

export default LoginFormUI;
