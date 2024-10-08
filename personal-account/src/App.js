import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import LoginForm from './components/LoginForm';
import ResultPage from './components/ResultPage';

function App() {
  console.log("App is rendering");
  return (
    <Router basename="/cabinet">
      <Routes>
        <Route path="/" element={<LoginForm />} />
        <Route path="/result" element={<ResultPage />} />
      </Routes>
    </Router>
  );
}

export default App;
