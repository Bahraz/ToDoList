document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('login-form');

  form.addEventListener('submit', async (e) => {
    e.preventDefault(); 

    if (!form.checkValidity()) {
      form.classList.add('was-validated');
      return;
    }

    const email = document.getElementById('login-email').value.trim();
    const password = document.getElementById('login-password').value.trim();

    try {
      const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ email, password, TokenCsrf: document.querySelector('input[name="TokenCsrf"]').value })
        });

        const data = await response.json();

        if (data.status === 'success') {
          console.log('Redirecting to tasks page...');
          window.location.replace('/tasks/view/active');
        } else {
          showAlert(data.data?.message ?? data.message ?? 'Unexpected error');
        }

      } catch (err) {
        console.error('Login error:', err);
        showAlert('Error connecting to the server.');
      }
  });

  function showAlert(message) {
    let alertBox = document.querySelector('#login-form .alert');
    
    if (!alertBox) {
      alertBox = document.createElement('div');
      alertBox.className = 'alert alert-danger mt-2';
      form.querySelector('.col-md-6').prepend(alertBox);
    }

    alertBox.textContent = message;
    alertBox.style.display = 'block';
  }
});
