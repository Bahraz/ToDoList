<h2 class="text-center mb-4">Your tasks</h2>
<div class="row justify-content-center">
  <div class="col-md-6">
    <ul class="list-group" id="task-list">
      <li class="list-group-item text-center">Ładowanie zadań...</li>
    </ul>
  </div>
</div>

<script>
const taskStatus = <?=json_encode($status ?? 'all') ?>;
document.addEventListener('DOMContentLoaded', async () => {
    const listEl = document.getElementById('task-list');
    listEl.innerHTML = '<li class="list-group-item text-center">Ładowanie zadań...</li>';

    try {
        const response = await fetch(`/api/tasks?status=${encodeURIComponent(taskStatus)}`); // podmień URL na swój endpoint API
        if (!response.ok) throw new Error('Błąd ładowania zadań');

        const tasks = await response.json();

        if (!tasks.length) {
            listEl.innerHTML = '<li class="list-group-item text-center">Brak zadań do wyświetlenia</li>';
            return;
        }

        listEl.innerHTML = ''; // wyczyść loader

        tasks.forEach(task => {
            const deleted = task.deleted === true;
            const completed = task.completed === true;

            const priorityClass = task.priority === 'high' ? 'danger' : (task.priority === 'low' ? 'secondary' : 'primary');

            const redirectUrl = encodeURIComponent(window.location.pathname);

            let actionButtons = '';
            if (!deleted) {
                if (!completed) {
                    actionButtons += `
                    <form method="post" action="/app/CompleteTask" class="me-2 d-inline">
                      <input type="hidden" name="redirect" value="${redirectUrl}">
                      <input type="hidden" name="task_id" value="${task.id}">
                      <button type="submit" class="btn btn-sm btn-success" title="End task">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                          <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                        </svg>
                      </button>
                    </form>`;
                } else {
                    actionButtons += `
                    <form method="post" action="/app/UncompleteTask" class="me-2 d-inline">
                      <input type="hidden" name="redirect" value="${redirectUrl}">
                      <input type="hidden" name="task_id" value="${task.id}">
                      <button type="submit" class="btn btn-sm btn-warning" title="Restore task">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                          <path d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                      </button>
                    </form>`;
                }
                actionButtons += `
                <form method="post" action="/app/DeleteTask" class="ms-2 d-inline">
                  <input type="hidden" name="redirect" value="${redirectUrl}">
                  <input type="hidden" name="task_id" value="${task.id}">
                  <button type="submit" class="btn btn-sm btn-danger" title="Delete task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                      <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                  </button>
                </form>`;
            } else {
                actionButtons = `<span class="text-muted fst-italic">Deleted</span>`;
            }

            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <span class="badge bg-${priorityClass} me-2 text-uppercase">${task.priority ?? ''}</span>
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
        listEl.innerHTML = `<li class="list-group-item text-danger text-center">Błąd ładowania zadań</li>`;
        console.error(err);
    }
});
</script>
