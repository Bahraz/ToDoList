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

    const data = await response.json();
    const tasks = Array.isArray(data) ? data : [];

    if (!tasks.length) {
      listEl.innerHTML = '<li class="list-group-item text-center">No tasks to display</li>';
      return;
    }

    listEl.innerHTML = '';

    tasks.forEach(task => {
      const deleted = task.deleted === true;
      const completed = task.completed === true;
      const priority = task.priority || 'normal';

      const priorityClass = priority === 'high' ? 'danger' :
                            priority === 'low' ? 'secondary' :
                            'primary';

      let actionButtons = '';
      if (!deleted) {
        if (!completed) {
          actionButtons += `
            <button class="btn btn-sm btn-success me-2 complete-task" data-id="${task.id}" title="End task">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
              </svg>
            </button>`;
        } else {
          actionButtons += `
            <button class="btn btn-sm btn-warning me-2 uncomplete-task" data-id="${task.id}" title="Restore task">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                <path d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5z"/>
              </svg>
            </button>`;
        }

        actionButtons += `
          <button class="btn btn-sm btn-danger delete-task" data-id="${task.id}" title="Delete task">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="margin-bottom: 3px;">
              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zM3.042 3.5l.846 10.58a1 1 0 0 0 .997.92h6.23a1 1 0 0 0 .997-.92L12.958 3.5H3.042z"/>
              <path d="M5.071 5.03a.5.5 0 0 1 .47-.53.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 1 1-.998.06l-.5-8.5zM10.129 5.03a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47zM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
            </svg>
          </button>`;
      } else {
        actionButtons = `<span class="text-muted fst-italic">Deleted</span>`;
      }

      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <span class="badge bg-${priorityClass} me-2 text-uppercase">${priority}</span>
            <div class="text-start">
              <div>${task.title ?? ''}</div>
              <small class="text-muted">${task.date ?? ''}</small>
            </div>
          </div>
          <div class="d-flex align-items-center">${actionButtons}</div>
        </div>
      `;

      listEl.appendChild(li);
    });

  } catch (err) {
    listEl.innerHTML = `<li class="list-group-item text-danger text-center">Error loading tasks</li>`;
    console.error(err);
  }
}

document.addEventListener('click', async function (e) {
  const btn = e.target.closest('button');

  if (!btn) return;

  const taskId = btn.dataset.id;

  if (btn.classList.contains('complete-task')) {
    await fetch('/api/CompleteTask', {
      method: 'POST',
      body: new URLSearchParams({ task_id: taskId })
    });
    loadTasks();
  }

  if (btn.classList.contains('uncomplete-task')) {
    await fetch('/api/UncompleteTask', {
      method: 'POST',
      body: new URLSearchParams({ task_id: taskId })
    });
    loadTasks();
  }

  if (btn.classList.contains('delete-task')) {
    await fetch('/api/DeleteTask', {
      method: 'POST',
      body: new URLSearchParams({ task_id: taskId })
    });
    loadTasks();
  }
});


document.addEventListener('DOMContentLoaded', () => {
  loadTasks();
});

</script>
