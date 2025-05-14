<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

if ($_SESSION['is_admin'] == 0) {
  header("Location: ../employees/index.php");
}
?>

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
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
      }
      
      .welcome-card {
        background: linear-gradient(135deg, #00897B 0%, #004D40 100%);
        color: white;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
      }

      .welcome-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
      }

      .welcome-card h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      }

      .welcome-card p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        line-height: 1.6;
      }

      .stats-container {
        margin-top: 2rem;
      }

      .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
      }

      .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      }

      .stat-icon {
        font-size: 2.5rem;
        color: #00897B;
        margin-bottom: 1.5rem;
        background: rgba(0, 137, 123, 0.1);
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
      }

      .stat-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 1rem;
      }

      .stat-card p {
        color: #636e72;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
      }

      .btn-outline-primary {
        color: #00897B;
        border-color: #00897B;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
      }

      .btn-outline-primary:hover {
        background: #00897B;
        border-color: #00897B;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 137, 123, 0.2);
      }

      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Admin Dashboard | Attendance System</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="welcome-card">
        <h1><i class="fas fa-user-shield mr-3"></i>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Manage your organization's attendance and leave requests efficiently from this central dashboard. Monitor employee activities and make informed decisions.</p>
      </div>
      
      <div class="row stats-container">
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3>Employee Management</h3>
            <p>View and manage all employee records, track performance, and handle user accounts efficiently.</p>
            <a href="all_users.php" class="btn btn-outline-primary">
              <i class="fas fa-arrow-right mr-2"></i>Manage Employees
            </a>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-clock"></i>
            </div>
            <h3>Attendance Tracking</h3>
            <p>Monitor daily attendance records, track time-ins and time-outs, and generate attendance reports.</p>
            <a href="all_attendances.php" class="btn btn-outline-primary">
              <i class="fas fa-arrow-right mr-2"></i>View Attendance
            </a>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Leave Management</h3>
            <p>Process employee leave requests, track leave balances, and maintain leave records.</p>
            <a href="leaves.php" class="btn btn-outline-primary">
              <i class="fas fa-arrow-right mr-2"></i>Handle Leaves
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>