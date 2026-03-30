import React, { useState } from 'react';
import '../styles/ResumeForm.css';

const ResumeForm = ({ formData, setFormData, onGenerateSuccess }) => {
  const [errors, setErrors] = useState({});
  const [isSubmitting, setIsSubmitting] = useState(false);

  const validateEmail = (email) => {
    return /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(email);
  };

  const validatePhone = (phone) => {
    if (!phone) return true;
    return /^[+]?[(]?[0-9]{1,4}[)]?[-\s.]?[(]?[0-9]{1,4}[)]?[-\s.]?[0-9]{3,4}[-\s.]?[0-9]{4,6}$/.test(phone);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
    
    // Clear error for this field
    if (errors[name]) {
      setErrors(prev => ({ ...prev, [name]: '' }));
    }
  };

  const validateForm = () => {
    const newErrors = {};
    
    if (!formData.fullName.trim()) {
      newErrors.fullName = 'Full name is required';
    } else if (formData.fullName.trim().length < 2) {
      newErrors.fullName = 'Name must be at least 2 characters';
    }
    
    if (!formData.email.trim()) {
      newErrors.email = 'Email address is required';
    } else if (!validateEmail(formData.email)) {
      newErrors.email = 'Please enter a valid email address';
    }
    
    if (formData.phone && !validatePhone(formData.phone)) {
      newErrors.phone = 'Please enter a valid phone number';
    }
    
    if (!formData.summary.trim()) {
      newErrors.summary = 'Professional summary is required';
    } else if (formData.summary.trim().length < 30) {
      newErrors.summary = 'Summary should be at least 30 characters';
    }
    
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (validateForm()) {
      setIsSubmitting(true);
      onGenerateSuccess(true);
      setTimeout(() => {
        onGenerateSuccess(false);
        setIsSubmitting(false);
      }, 3000);
    } else {
      onGenerateSuccess(false);
      // Scroll to first error
      const firstError = document.querySelector('.error-input');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }
  };

  const handleReset = () => {
    if (window.confirm('Are you sure you want to reset all fields?')) {
      setFormData({
        fullName: '',
        email: '',
        phone: '',
        summary: '',
        education: '',
        skills: '',
        experience: '',
        achievements: ''
      });
      setErrors({});
    }
  };

  return (
    <form onSubmit={handleSubmit} className="resume-form">
      <div className="form-section">
        <h3 className="section-heading">
          <i className="fas fa-user"></i>
          Personal Information
        </h3>
        
        <div className="form-group">
          <label htmlFor="fullName">
            Full Name <span className="required">*</span>
          </label>
          <input
            type="text"
            id="fullName"
            name="fullName"
            value={formData.fullName}
            onChange={handleChange}
            className={errors.fullName ? 'error-input' : ''}
            placeholder="Johnathan Doe"
            autoComplete="name"
          />
          {errors.fullName && <div className="error-message">{errors.fullName}</div>}
        </div>

        <div className="form-row">
          <div className="form-group">
            <label htmlFor="email">
              Email Address <span className="required">*</span>
            </label>
            <input
              type="email"
              id="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              className={errors.email ? 'error-input' : ''}
              placeholder="john@example.com"
              autoComplete="email"
            />
            {errors.email && <div className="error-message">{errors.email}</div>}
          </div>

          <div className="form-group">
            <label htmlFor="phone">Phone Number</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              value={formData.phone}
              onChange={handleChange}
              className={errors.phone ? 'error-input' : ''}
              placeholder="+1 234 567 8900"
              autoComplete="tel"
            />
            {errors.phone && <div className="error-message">{errors.phone}</div>}
          </div>
        </div>
      </div>

      <div className="form-section">
        <h3 className="section-heading">
          <i className="fas fa-file-alt"></i>
          Professional Summary
        </h3>
        
        <div className="form-group">
          <label htmlFor="summary">
            Summary <span className="required">*</span>
          </label>
          <textarea
            id="summary"
            name="summary"
            value={formData.summary}
            onChange={handleChange}
            className={errors.summary ? 'error-input' : ''}
            placeholder="Results-driven professional with 5+ years of experience in software development, specializing in React and modern web technologies..."
            rows="4"
          />
          <div className="character-count">
            {formData.summary.length} / 500 characters
          </div>
          {errors.summary && <div className="error-message">{errors.summary}</div>}
        </div>
      </div>

      <div className="form-section">
        <h3 className="section-heading">
          <i className="fas fa-graduation-cap"></i>
          Education
        </h3>
        
        <div className="form-group">
          <label htmlFor="education">Degree & Institution</label>
          <input
            type="text"
            id="education"
            name="education"
            value={formData.education}
            onChange={handleChange}
            placeholder="B.Sc. Computer Science, Stanford University, 2020"
          />
        </div>
      </div>

      <div className="form-section">
        <h3 className="section-heading">
          <i className="fas fa-code"></i>
          Technical Skills
        </h3>
        
        <div className="form-group">
          <label htmlFor="skills">Skills (comma separated)</label>
          <input
            type="text"
            id="skills"
            name="skills"
            value={formData.skills}
            onChange={handleChange}
            placeholder="React, Node.js, Python, AWS, MongoDB, GraphQL"
          />
          <div className="field-hint">
            <i className="fas fa-info-circle"></i>
            Separate skills with commas for better formatting
          </div>
        </div>
      </div>

      <div className="form-section">
        <h3 className="section-heading">
          <i className="fas fa-briefcase"></i>
          Work Experience
        </h3>
        
        <div className="form-group">
          <label htmlFor="experience">Professional Experience</label>
          <textarea
            id="experience"
            name="experience"
            value={formData.experience}
            onChange={handleChange}
            placeholder="Senior Frontend Developer | Tech Corp | 2021-Present
• Led development of 5+ React applications serving 100k+ users
• Implemented CI/CD pipelines reducing deployment time by 40%
• Mentored 3 junior developers and conducted code reviews"
            rows="5"
          />
        </div>
      </div>

      <div className="form-section">
        <h3 className="section-heading">
          <i className="fas fa-trophy"></i>
          Achievements
        </h3>
        
        <div className="form-group">
          <label htmlFor="achievements">Key Achievements</label>
          <textarea
            id="achievements"
            name="achievements"
            value={formData.achievements}
            onChange={handleChange}
            placeholder="• Employee of the Month (Q3 2023)
• Published 3 technical articles with 10k+ reads
• Awarded Best Innovation in Hackathon 2022"
            rows="4"
          />
        </div>
      </div>

      <div className="form-actions">
        <button type="button" onClick={handleReset} className="btn-reset">
          <i className="fas fa-undo-alt"></i>
          Reset Form
        </button>
        <button type="submit" className="btn-generate" disabled={isSubmitting}>
          {isSubmitting ? (
            <>
              <i className="fas fa-spinner fa-spin"></i>
              Generating...
            </>
          ) : (
            <>
              <i className="fas fa-magic"></i>
              Generate Resume
            </>
          )}
        </button>
      </div>
    </form>
  );
};

export default ResumeForm;
