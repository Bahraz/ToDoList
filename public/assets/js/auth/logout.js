document.addEventListener('DOMContentLoaded', () => {
  const logoutBtn = document.getElementById('logout-btn');
  if (!logoutBtn) return;

  logoutBtn.addEventListener('click', async (e) => {
    e.preventDefault(); 

    try {
      const response = await fetch('/api/logout', { method: 'POST' });
      const data = await response.json();

      if (data.status === 'success' && data.data.message) {
        window.location.href = '/';
      } else {
        alert('Logout failed');
      }

    } catch (err) {
      console.error(err);
      alert('Network error');
    }
  });
});
