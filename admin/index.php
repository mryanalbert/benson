<?php
session_start();
if (isset($_SESSION['admin_system'])) {
  header('location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./libs/bootstrap.min.css" />
  <title>Login</title>
</head>
<body class="bg-light">
  <div class="container">
    <div class="row vh-100">
      <div class="col-md-12 my-auto">
        <div class="card mx-auto rounded-0 border-0 shadow" style="width:350px">
          <div class="card-header bg-primary text-white rounded-0 text-center">
            <h4>Admin Login</h4>
          </div>
          <div class="card-body">
            <form id="login-form">
              <label for="username">Username:</label>
              <input type="text" name="username" id="username" class="form-control mb-2" autofocus required>

              <label for="password">Password:</label>
              <input type="password" name="password" id="password" class="form-control mb-3" required>
              
              <input type="submit" id="login-btn" class="btn btn-primary w-100" value="Login">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="./libs/bootstrap.bundle.js"></script>
  <script src="./libs/jquery.min.js"></script>
  <script src="./libs/sweetalert2.all.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#login-btn").click(function(e) {
        if ($("#login-form")[0].checkValidity()) {
          e.preventDefault()

          $(this).val('Logging in...')
          $(this).prop('disabled', true)

          $.ajax({
            url: 'assets/action.php',
            method: 'post',
            data: $('#login-form').serialize() + '&action=login',
            success: function(res) {
              if (res) {
                window.location = 'dashboard.php'
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Invalid username or password!',
                })
                $("#login-btn").val('Login')
                $("#login-btn").prop('disabled', false)
              }
            }
          })
        }
      })
    })
  </script>
</body>
</html>