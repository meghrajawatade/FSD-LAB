import React from 'react';
import '../styles/ResumePreview.css';

const ResumePreview = ({ resumeData }) => {
  const { fullName, email, phone, summary, education, skills, experience, achievements } = resumeData;
  
  const hasData = fullName || email || phone || summary || education || skills || experience || achievements;
  
  const parseSkills = (skillsString) => {
    if (!skillsString) return [];
    return skillsString.split(',').map(s => s.trim()).filter(s => s);
  };
  
  const skillsArray = parseSkills(skills);
  
  if (!hasData) {
    return (
      <div className="preview-empty">
        <div className="empty-icon">
          <i className="fas fa-file-contract"></i>
        </div>
        <h3>Your Resume Preview</h3>
        <p>Fill in the form on the left to see your professional resume come to life.</p>
        <div className="empty-tips">
          <span><i className="fas fa-check-circle"></i> Start with your name</span>
          <span><i className="fas fa-check-circle"></i> Add a compelling summary</span>
          <span><i className="fas fa-check-circle"></i> Showcase your skills</span>
        </div>
      </div>
    );
  }
  
  return (
    <div className="resume-preview">
      <div className="preview-header">
        <h1 className="preview-name">{fullName || 'Your Name'}</h1>
        <div className="preview-contact">
          {email && (
            <div className="contact-item">
              <i className="fas fa-envelope"></i>
              <span>{email}</span>
            </div>
          )}
          {phone && (
            <div className="contact-item">
              <i className="fas fa-phone-alt"></i>
              <span>{phone}</span>
            </div>
          )}
        </div>
      </div>
      
      {summary && (
        <div className="preview-section">
          <div className="section-title">
            <i className="fas fa-user-edit"></i>
            <h2>Professional Summary</h2>
          </div>
          <p className="section-content">{summary}</p>
        </div>
      )}
      
      {education && (
        <div className="preview-section">
          <div className="section-title">
            <i className="fas fa-graduation-cap"></i>
            <h2>Education</h2>
          </div>
          <p className="section-content">{education}</p>
        </div>
      )}
      
      {skillsArray.length > 0 && (
        <div className="preview-section">
          <div className="section-title">
            <i className="fas fa-code"></i>
            <h2>Technical Skills</h2>
          </div>
          <div className="skills-container">
            {skillsArray.map((skill, index) => (
              <span key={index} className="skill-tag">
                {skill}
              </span>
            ))}
          </div>
        </div>
      )}
      
      {experience && (
        <div className="preview-section">
          <div className="section-title">
            <i className="fas fa-briefcase"></i>
            <h2>Work Experience</h2>
          </div>
          <div className="section-content experience-content">
            {experience.split('\n').map((line, index) => (
              line.trim() && <div key={index} className="experience-line">{line}</div>
            ))}
          </div>
        </div>
      )}
      
      {achievements && (
        <div className="preview-section">
          <div className="section-title">
            <i className="fas fa-trophy"></i>
            <h2>Achievements</h2>
          </div>
          <div className="section-content achievements-content">
            {achievements.split('\n').map((line, index) => (
              line.trim() && <div key={index} className="achievement-line">• {line}</div>
            ))}
          </div>
        </div>
      )}
      
      <div className="preview-footer">
        <p>Generated with Elysian Resume Builder</p>
      </div>
    </div>
  );
};

export default ResumePreview;