  (() => {
    'use strict';
    const form = document.getElementById('register-form');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      form.classList.add('was-validated');

      if (!form.checkValidity()) {
        return;
      }

      const password = document.getElementById('register-password').value;
      const confirmPassword = document.getElementById('register-confirm-password').value;

      if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
      }

      const formData = new FormData(form);

      try {
        const response = await fetch('/api/register', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (response.ok) {
          window.location.href = '/view/forms/active';
        } else {
          alert(data.message || 'Registration failed');
        }
      } catch (err) {
        alert('A network error occurred.');
        console.error(err);
      }
    });
  })();
