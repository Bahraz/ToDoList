document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('add-task-form');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('/api/add-task', {
        method: 'POST',
        body: formData
      });

      if (response.ok) {
        window.location.href = '/tasks/view/active';
      } else {
        const data = await response.json();
        alert(data.message || 'Error adding task');
      }
    } catch (err) {
      alert('A network error occurred.');
      console.error(err);
    }
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('add-task-form');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('/api/AddTask', {
        method: 'POST',
        body: formData
      });

      if (response.ok) {
        window.location.href = '/tasks/view/active';
      } else {
        const data = await response.json();
        alert(data.message || 'Error adding task');
      }
    } catch (err) {
      alert('A network error occurred.');
      console.error(err);
    }
  });
});

