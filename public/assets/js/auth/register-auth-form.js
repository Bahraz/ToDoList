  (() => {
    'use strict';
    const form = document.getElementById('register-form');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      form.classList.add('was-validated');

      if (!form.checkValidity()) {
        return;
      }

      const email = document.getElementById('register-email').value;
      const password = document.getElementById('register-password').value;
      const confirmPassword = document.getElementById('register-confirm-password').value;

      if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
      }

            try {
      const response = await fetch('/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password, confirmPassword, csrf_token: document.querySelector('input[name="csrf_token"]').value })
      });

        const data = await response.json();

        if (response.ok) {
          window.location.href = '/tasks/view/active';
        } else {
          alert(data.message || 'Registration failed');
        }
      } catch (err) {
        alert('A network error occurred.');
        console.error(err);
      }
    });
  })();
