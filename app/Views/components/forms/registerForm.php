<form class="row justify-content-center needs-validation" id="register-form" novalidate>
  <div class="col-md-6 col-sm-10 p-4 border rounded shadow-sm">
    <h3 class="text-center mb-4">Register</h3>

    <div class="mb-3">
      <label for="register-email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="register-email" name="email" placeholder="Enter your email" required>
      <div class="invalid-feedback">
        Please enter a valid email address.
      </div>
    </div>

    <div class="mb-3">
      <label for="register-password" class="form-label">Password</label>
      <input type="password" class="form-control" id="register-password" name="password" placeholder="Enter your password" required>
      <div class="invalid-feedback">
        Please enter a password.
      </div>
    </div>

    <div class="mb-3">
      <label for="register-confirm-password" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="register-confirm-password" name="confirm_password" placeholder="Confirm your password" required>
      <div class="invalid-feedback">
        Please confirm your password.
      </div>
    </div>

    <div class="d-grid mb-3">
      <button class="btn btn-primary" type="submit">Register</button>
    </div>

    <div class="text-center">
      <small>
        Already have an account? <a href="/login">Login here</a>
      </small>
    </div>
  </div>
</form>

<script src="/assets/js/auth/register-auth-form.js"></script>
