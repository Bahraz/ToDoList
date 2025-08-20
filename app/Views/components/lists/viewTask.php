<h2 class="text-center mb-4">Your tasks</h2>
<div class="row justify-content-center">
  <div class="col-md-6">
    <ul class="list-group" id="task-list">
      <li class="list-group-item text-center">Loading tasks...</li>
    </ul>
  </div>
</div>


<script>
  window.taskStatus = <?= json_encode($status ?? 'all') ?>;
</script>
<script src="/assets/js/tasks/view-task-lists.js"></script>

<?php
echo $_SESSION['user_id'] ?? 'No user logged in';
echo '  |  ';
echo $_SESSION['user_email'] ?? 'No user email set';