import React from 'react';
import { useLocation } from 'react-router-dom';

function ResultPage() {
  const location = useLocation();
  const { result } = location.state || {};

  return (
    <div className="result__container">
      <h1>Login Result</h1>
      {result ? (
        <p>{result}</p>
      ) : (
        <p>No result available. Please try logging in again.</p>
      )}
    </div>
  );
}

export default ResultPage;
