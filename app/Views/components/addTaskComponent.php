<form class="row justify-content-center mb-5" id="add-task-form">
  <div class="col-md-6 col-sm-8">
    <label for="task-input" class="form-label">Add a new task</label>
    <div class="input-group mb-3">
      <input type="text" name="title" id="task-input" class="form-control" placeholder="Enter a new task" required>
      <button class="btn btn-primary" type="submit">Add</button>    
    </div>
    <div class="row">
      <div class="col-md-6">
        <label for="task-priority" class="form-label">Set priority</label>
        <select class="form-select form-select-sm" name="priority" id="task-priority">
          <option value="low">Low</option>
          <option value="normal" selected>Normal</option>
          <option value="high">High</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="task-date" class="form-label">Select a date</label>
        <div class="input-group">
          <input type="text" name="date" id="task-date" class="form-control" placeholder="YYYY-MM-DD" required>
          <div class="btn btn-info" id="open-flatpickr" role="button" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16" style=" margin-bottom: 4px;">
              <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
            </svg>
            </svg>
          </div> 
        </div>
      </div>
    </div>
  </div>
</form>

<script>
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
        window.location.href = '/app/ViewActiveTask';
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
</script>

