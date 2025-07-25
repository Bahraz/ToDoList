<h2 class="text-center mb-4">Your tasks</h2>
<div class="row justify-content-center">
  <div class="col-md-6">
    <ul class="list-group">
      <?php foreach ($tasks as $task): ?>
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <span class="badge bg-<?= 
                ($task['priority'] ?? '') === 'high' ? 'danger' : 
                ((($task['priority'] ?? '') === 'low') ? 'secondary' : 'primary') 
              ?> me-2 text-uppercase">
                <?= htmlspecialchars($task['priority'] ?? '') ?>
              </span>
              <div class="text-start">
                <div><?= htmlspecialchars($task['title'] ?? '') ?></div>
                <small class="text-muted"><?= htmlspecialchars($task['date'] ?? '') ?></small>
              </div>
            </div>

            <div class="d-flex align-items-center">
              <?php
                $deleted = isset($task['deleted']) ? (bool)$task['deleted'] : false;
                $completed = isset($task['completed']) ? (bool)$task['completed'] : false;
              ?>

              <?php if (!$deleted): ?>
                <?php if (!$completed): ?>
                  <form method="post" action="/app/CompleteTask" class="me-2">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <input type="hidden" name="task_id" value="<?= (int)($task['id'] ?? 0) ?>">
                    <button type="submit" class="btn btn-sm btn-success" title="End task">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                      </svg>
                    </button>
                  </form>
                <?php else: ?>
                  <form method="post" action="/app/UncompleteTask" class="me-2">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <input type="hidden" name="task_id" value="<?= (int)($task['id'] ?? 0) ?>">
                    <button type="submit" class="btn btn-sm btn-warning" title="Restore task">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                        <path d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5z"/>
                      </svg>
                    </button>
                  </form>
                <?php endif; ?>

                <form method="post" action="/app/DeleteTask" class="ms-2">
                  <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                  <input type="hidden" name="task_id" value="<?= (int)($task['id'] ?? 0) ?>">
                  <button type="submit" class="btn btn-sm btn-danger" title="Delete task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="margin-bottom: 3px;">
                      <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                  </button>
                </form>
              <?php else: ?>
                <span class="text-muted fst-italic">Deleted</span>
              <?php endif; ?>
            </div>

          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
