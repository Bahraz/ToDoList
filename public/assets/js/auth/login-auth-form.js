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
          body: JSON.stringify({ email, password, csrf_token: document.querySelector('input[name="csrf_token"]').value })
        });

        const data = await response.json();

        if (data.status === 'success') {
          console.log('Login successful:', data);
          showAlert(data.message);
          // window.location.href = '/tasks/view/active';
        } else {
          showAlert(data.message ?? 'Unexpected error');
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
