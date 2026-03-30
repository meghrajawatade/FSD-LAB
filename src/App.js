import React, { useEffect, useState } from 'react';
import ResumeForm from './components/ResumeForm';
import ResumePreview from './components/ResumePreview';
import ThemeToggle from './components/ThemeToggle';
import SuccessMessage from './components/SuccessMessage';
import './App.css';

const App = () => {
  const [darkMode, setDarkMode] = useState(false);
  const [showSuccess, setShowSuccess] = useState(false);
  const [formData, setFormData] = useState({
    fullName: '',
    email: '',
    phone: '',
    summary: '',
    education: '',
    skills: '',
    experience: '',
    achievements: ''
  });

  const toggleDarkMode = () => {
    setDarkMode((prevDarkMode) => !prevDarkMode);
  };

  useEffect(() => {
    document.body.classList.toggle('dark', darkMode);

    return () => {
      document.body.classList.remove('dark');
    };
  }, [darkMode]);

  const handleGenerateSuccess = (success) => {
    setShowSuccess(success);
  };

  return (
    <div className={`app-container ${darkMode ? 'dark-theme' : ''}`}>
      <ThemeToggle darkMode={darkMode} toggleDarkMode={toggleDarkMode} />
      
      <div className="hero-section">
        <h1 className="hero-title">
          <span className="title-gradient">Elysian Resume</span>
        </h1>
        <p className="hero-subtitle">
          Create stunning, professional resumes in minutes. Real-time preview, 
          modern design, and complete control over your career story.
        </p>
        <div className="hero-stats">
          <div className="stat">
            <i className="fas fa-file-alt"></i>
            <span>500+ Templates</span>
          </div>
          <div className="stat">
            <i className="fas fa-users"></i>
            <span>10k+ Users</span>
          </div>
          <div className="stat">
            <i className="fas fa-star"></i>
            <span>4.9 Rating</span>
          </div>
        </div>
      </div>

      <div className="builder-grid">
        <div className="form-card">
          <div className="card-header">
            <h2>
              <i className="fas fa-pen-fancy"></i>
              Resume Details
            </h2>
            <p className="card-subtitle">Fill in your professional information</p>
          </div>
          <div className="card-body">
            <ResumeForm 
              formData={formData}
              setFormData={setFormData}
              onGenerateSuccess={handleGenerateSuccess}
            />
            {showSuccess && <SuccessMessage />}
          </div>
        </div>

        <div className="preview-card">
          <div className="card-header">
            <h2>
              <i className="fas fa-eye"></i>
              Live Preview
            </h2>
            <p className="card-subtitle">Your resume updates in real-time</p>
          </div>
          <div className="card-body preview-body">
            <ResumePreview resumeData={formData} />
          </div>
        </div>
      </div>

      <footer className="app-footer">
        <p>© 2024 Elysian Resume Builder | Craft your future with confidence</p>
        <div className="footer-links">
          <a href="https://github.com" target="_blank" rel="noreferrer">
            <i className="fab fa-github"></i>
          </a>
          <a href="https://www.linkedin.com" target="_blank" rel="noreferrer">
            <i className="fab fa-linkedin"></i>
          </a>
          <a href="https://x.com" target="_blank" rel="noreferrer">
            <i className="fab fa-twitter"></i>
          </a>
        </div>
      </footer>
    </div>
  );
};

export default App;
