// Bootstrap client-side validation with custom email and password checks
(() => {
  'use strict';

  const form = document.getElementById('login-form');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Get references to the input fields
    const emailInput = document.getElementById('login-email');
    const passwordInput = document.getElementById('login-password');

    // Get the trimmed input values
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    let isValid = true;

    // Email validation using a simple regex pattern
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      emailInput.classList.add('is-invalid');      // Add Bootstrap error class
      isValid = false;
    } else {
      emailInput.classList.remove('is-invalid');
      emailInput.classList.add('is-valid');        // Optional: add valid state
    }

    // Password validation:
    // At least 6 characters, 1 lowercase, 1 uppercase, 1 digit, and 1 special character
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{6,}$/;
    if (!passwordRegex.test(password)) {
      passwordInput.classList.add('is-invalid');
      isValid = false;
    } else {
      passwordInput.classList.remove('is-invalid');
      passwordInput.classList.add('is-valid');
    }

    // Mark the form as validated (for Bootstrap visual feedback)
    form.classList.add('was-validated');

    // Stop submission if form is invalid
    if (!isValid) {
      return;
    }

    // Prepare form data for submission
    const formData = new FormData(form);

    try {
      // Send login request to API endpoint
      const response = await fetch('/api/Login', {
        method: 'POST',
        body: formData
      });

      const data = await response.json();

      if (response.ok) {
        // Redirect on successful login
        window.location.href = '/tasks/view/active';
      } else {
        // Show error message returned from API
        alert(data.message || 'Login failed');
      }

    } catch (err) {
      // Handle network errors
      alert('A network error occurred.');
      console.error(err);
    }
  });
})();
