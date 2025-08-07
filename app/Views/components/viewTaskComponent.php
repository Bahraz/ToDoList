<h2 class="text-center mb-4">Your tasks</h2>
<div class="row justify-content-center">
  <div class="col-md-6">
    <ul class="list-group" id="task-list">
      <li class="list-group-item text-center">Loading tasks...</li>
    </ul>
  </div>
</div>

<script>
const taskStatus = <?= json_encode($status ?? 'all') ?>;

async function loadTasks() {
  const listEl = document.getElementById('task-list');
  listEl.innerHTML = '<li class="list-group-item text-center">Loading tasks...</li>';

  try {
    const response = await fetch(`/api/tasks?status=${encodeURIComponent(taskStatus)}`);
    if (!response.ok) throw new Error('Error loading tasks');

    const tasks = await response.json();
    if (!Array.isArray(tasks) || tasks.length === 0) {
      listEl.innerHTML = '<li class="list-group-item text-center">No tasks to display</li>';
      return;
    }

    listEl.innerHTML = '';

    tasks.forEach(task => {
      const { id, title, date, completed, deleted, priority } = task;

      const priorityClass = {
        high: 'danger',
        low: 'secondary',
        normal: 'primary'
      }[priority] || 'primary';

      let actionButtons = '';

      if (taskStatus === 'deleted') {
        actionButtons = `<span class="text-muted fst-italic">Deleted</span>`;
      } else {
        if (taskStatus === 'completed' || (taskStatus === 'all' && completed)) {
          actionButtons += `
            <button class="btn btn-sm btn-warning me-2 uncomplete-task" data-id="${id}" title="Restore task" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                <path d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5z"/>
              </svg>
            </button>`;
        } else if (!completed) {
          actionButtons += `
            <button class="btn btn-sm btn-success me-2 complete-task" data-id="${id}" title="End task" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
              </svg>
            </button>`;
        }

        actionButtons += `
          <button class="btn btn-sm btn-danger delete-task" data-id="${id}" title="Delete task" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="margin-bottom: 3px;">
              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zM3.042 3.5l.846 10.58a1 1 0 0 0 .997.92h6.23a1 1 0 0 0 .997-.92L12.958 3.5H3.042z"/>
              <path d="M5.071 5.03a.5.5 0 0 1 .47-.53.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 1 1-.998.06l-.5-8.5zM10.129 5.03a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47zM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
            </svg>
          </button>`;
      }

      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <span class="badge bg-${priorityClass} me-2 text-uppercase">${priority}</span>
            <div class="text-start">
              <div>${title}</div>
              <small class="text-muted">${date}</small>
            </div>
          </div>
          <div class="d-flex align-items-center">${actionButtons}</div>
        </div>
      `;

      listEl.appendChild(li);
    });

  } catch (err) {
    console.error(err);
    listEl.innerHTML = `<li class="list-group-item text-danger text-center">Error loading tasks</li>`;
  }
}

document.addEventListener('click', async function (e) {
  const btn = e.target.closest('button');
  if (!btn) return;

  e.preventDefault();
  e.stopPropagation();

  console.log('Clicked button:', btn);
  const taskId = btn.dataset.id;
  if (!taskId) {
    console.log('No task ID found on button');
    return;
  }

  let body = null;

  if (btn.classList.contains('complete-task')) {
    console.log('Completing task', taskId);
    body = JSON.stringify({ completed: true });
  } else if (btn.classList.contains('uncomplete-task')) {
    console.log('Uncompleting task', taskId);
    body = JSON.stringify({ completed: false });
  } else if (btn.classList.contains('delete-task')) {
    console.log('Deleting task', taskId);
    body = JSON.stringify({ deleted: true });
  } else {
    console.log('Clicked button is not action button');
    return;
  }

  try {
    const response = await fetch(`/api/tasks/${taskId}`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: body,
    });

    if (!response.ok) {
      alert('Failed to update task');
      console.error('Response status:', response.status);
    } else {
      console.log('Task updated, reloading list');
      loadTasks();
    }
  } catch (error) {
    alert('Network error');
    console.error(error);
  }
});
document.addEventListener('DOMContentLoaded', loadTasks);
</script>
