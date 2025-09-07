<?php 
  if(isset($_SESSION['user_id'])) {
      header('Location: /tasks/view/active');
      exit;
  }

  if(session_status() === PHP_SESSION_NONE) {
      session_start();
  }

?>

<form class="row justify-content-center needs-validation" id="login-form" novalidate>

  <input type="hidden" name="csrf_token" value="<?= \Bahraz\ToDoApp\Core\Csrf::generateCsrf() ?>">

  <div class="col-md-6 col-sm-10 p-4 border rounded shadow-sm">
    <h3 class="text-center mb-4">Login</h3>

    <div class="mb-3">
      <label for="login-email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter your email" required>
      <div class="invalid-feedback">
        Please enter a valid email address.
      </div>
    </div>

    <div class="mb-3">
      <label for="login-password" class="form-label">Password</label>
      <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter your password" required>
      <div class="invalid-feedback">
        Please enter your password.
      </div>
    </div>

    <div class="d-grid mb-3">
      <button class="btn btn-primary" type="submit">Login</button>
    </div>

    <div class="text-center">
      <small>
        Don't have an account? <a href="/register">Register here</a>
      </small>
    </div>
  </div>
</form>

<script src="/assets/js/auth/login-auth-form.js"></script>