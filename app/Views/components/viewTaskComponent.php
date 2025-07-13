<div class="container text-center py-5">

<h2 class="mb-4">Twoje zadania</h2>

<ul class="list-group">
  <?php foreach ($tasks as $task): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <input class="form-check-input me-2" type="checkbox" <?= $task['completed'] ? 'checked' : '' ?>>
        <?= htmlspecialchars($task['title']) ?>
      </div>
      <button class="btn btn-sm btn-danger">Usuń</button>
    </li>
  <?php endforeach; ?>
</ul>

</div
