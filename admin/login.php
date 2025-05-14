<?php require_once 'core/dbConfig.php'; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
      }

      body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.pexels.com/photos/3183153/pexels-photo-3183153.jpeg?auto=compress&cs=tinysrgb&w=1920') center/cover no-repeat;
        filter: brightness(0.5);
        z-index: -1;
      }

      .login-container {
        width: 100%;
        max-width: 450px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        overflow: hidden;
        transform: translateY(0);
        transition: all 0.3s ease;
      }

      .login-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.45);
      }

      .login-header {
        background: rgba(0, 137, 123, 0.2);
        padding: 30px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      }

      .login-header h2 {
        margin: 0;
        color: #fff;
        font-weight: 600;
        font-size: 2rem;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      }

      .login-body {
        padding: 40px;
      }

      .form-group {
        margin-bottom: 25px;
        position: relative;
      }

      .form-group label {
        color: #fff;
        font-weight: 500;
        margin-bottom: 10px;
        display: block;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        font-size: 1.1rem;
      }

      .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 15px 20px;
        padding-left: 50px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
      }

      .form-control:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(0, 137, 123, 0.5);
        box-shadow: 0 0 15px rgba(0, 137, 123, 0.3);
      }

      .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }

      .input-icon {
        position: absolute;
        left: 20px;
        top: 48px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
      }

      .btn-primary {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 40px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
        width: 100%;
      }

      .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 137, 123, 0.4);
        background: linear-gradient(135deg, #004D40 0%, #00897B 100%);
      }

      .alert {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
      }

      .alert-success {
        background: rgba(40, 167, 69, 0.2);
        border-left: 4px solid #28a745;
      }

      .alert-danger {
        background: rgba(220, 53, 69, 0.2);
        border-left: 4px solid #dc3545;
      }

      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>
    <title>Admin Portal | Login</title>
  </head>
  <body>
    <div class="container">
      <div class="login-container">
        <div class="login-header">
          <h2><i class="fas fa-user-shield mr-2"></i>Admin Portal</h2>
        </div>
        <form action="core/handleForms.php" method="POST">
          <div class="login-body">
            <?php  
            if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
              if ($_SESSION['status'] == "200") {
                echo "<div class='alert alert-success'><i class='fas fa-check-circle mr-2'></i>{$_SESSION['message']}</div>";
              } else {
                echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle mr-2'></i>{$_SESSION['message']}</div>"; 
              }
            }
            unset($_SESSION['message']);
            unset($_SESSION['status']);
            ?>
            <div class="form-group">
              <label for="username">Username</label>
              <i class="fas fa-user input-icon"></i>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <i class="fas fa-lock input-icon"></i>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="loginUserBtn">
              <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>