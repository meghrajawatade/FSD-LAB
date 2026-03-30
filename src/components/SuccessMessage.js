import React from 'react';

const SuccessMessage = () => {
  return (
    <div className="success-message" role="status" aria-live="polite">
      <i className="fas fa-check-circle" aria-hidden="true"></i>
      <div className="success-content">
        <strong>Resume updated successfully</strong>
        <span>Your latest changes are reflected in the live preview.</span>
      </div>
    </div>
  );
};

export default SuccessMessage;
