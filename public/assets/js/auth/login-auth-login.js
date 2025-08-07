
  // Bootstrap client-side validation
  (() => {
    'use strict';
    const form = document.getElementById('login-form');
    
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      form.classList.add('was-validated');

      if (!form.checkValidity()) {
        return;
      }

      const formData = new FormData(form);

      try {
        const response = await fetch('/api/Login', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (response.ok) {
          window.location.href = '/tasks/view/active'; //  
        } else {
          alert(data.message || 'Login failed');
        }

      } catch (err) {
        alert('A network error occurred.');
        console.error(err);
      }
    });
  })();
