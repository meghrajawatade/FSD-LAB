import React from 'react';

const ThemeToggle = ({ darkMode, toggleDarkMode }) => {
  return (
    <div className="theme-toggle-container">
      <button type="button" onClick={toggleDarkMode} className="theme-toggle-btn">
        {darkMode ? (
          <>
            <i className="fas fa-sun"></i>
            <span>Light Mode</span>
          </>
        ) : (
          <>
            <i className="fas fa-moon"></i>
            <span>Dark Mode</span>
          </>
        )}
      </button>
    </div>
  );
};

export default ThemeToggle;
