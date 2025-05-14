<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

if ($_SESSION['is_admin'] == 1) {
  header("Location: ../admin/index.php");
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
        background: linear-gradient(135deg, #FF6B6B 0%, #556270 100%);
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

      .welcome-card h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      }

      .time-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .time-display {
        font-size: 3.5rem;
        font-weight: 700;
        color: #FF6B6B;
        margin: 1.5rem 0;
        text-shadow: 0 2px 4px rgba(255, 107, 107, 0.2);
        font-family: 'Inter', monospace;
      }

      .attendance-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .attendance-status {
        padding: 0.75em 1.5em;
        border-radius: 30px;
        font-weight: 600;
        display: inline-block;
        font-size: 0.9rem;
      }

      .status-success {
        background-color: #4caf50;
        color: white;
        box-shadow: 0 2px 4px rgba(76, 175, 80, 0.2);
      }

      .status-pending {
        background-color: #f44336;
        color: white;
        box-shadow: 0 2px 4px rgba(244, 67, 54, 0.2);
      }

      .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 2rem;
      }

      .action-button {
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #2d3436;
      }

      .action-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: #2d3436;
      }

      .action-icon {
        font-size: 2rem;
        color: #FF6B6B;
        margin-bottom: 1rem;
      }

      .action-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
      }

      .action-description {
        font-size: 0.9rem;
        color: #636e72;
        margin: 0;
      }

      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
    <title>Employee Dashboard | Attendance System</title>
  </head>
  <body onload="startTime()">
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid px-4">
      <div class="welcome-card">
        <h2><i class="fas fa-user-tie mr-3"></i>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p class="lead mb-0">Track your attendance and manage your leaves efficiently from your personalized dashboard.</p>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="time-card">
            <h4><i class="fas fa-clock mr-2"></i>Current Time</h4>
            <div class="time-display" id="txt"></div>
            <p class="text-muted mb-0">Philippine Standard Time</p>
          </div>

          <div class="quick-actions">
            <a href="file_an_attendance.php" class="action-button">
              <div class="action-icon">
                <i class="fas fa-clock"></i>
              </div>
              <h5 class="action-title">Record Attendance</h5>
              <p class="action-description">Log your daily time in/out</p>
            </a>
            
            <a href="file_a_leave.php" class="action-button">
              <div class="action-icon">
                <i class="fas fa-calendar-plus"></i>
              </div>
              <h5 class="action-title">Request Leave</h5>
              <p class="action-description">Submit a leave application</p>
            </a>
          </div>
        </div>

        <div class="col-md-6">
          <div class="attendance-card">
            <h4><i class="fas fa-calendar-check mr-2"></i>Today's Attendance</h4>
            <p class="text-muted">
              <?php 
                $date = date('Y-m-d H:i:s'); 
                echo date('F d, Y', strtotime($date));
              ?>
            </p>
            
            <div class="row mt-4">
              <div class="col-md-6">
                <h5>Time In</h5>
                <?php 
                $getTimeInOrOutForToday = getTimeInOrOutForToday($pdo, $_SESSION['user_id'], date('Y-m-d', strtotime($date)), "time_in");
                if (!empty($getTimeInOrOutForToday)) {
                  echo "<span class='attendance-status status-success'><i class='fas fa-check-circle mr-2'></i>" . 
                       date('h:i A', strtotime($getTimeInOrOutForToday['timestamp_record_added'])) . "</span>";
                } else {
                  echo "<span class='attendance-status status-pending'><i class='fas fa-times-circle mr-2'></i>Not yet recorded</span>";
                }
                ?>
              </div>
              
              <div class="col-md-6">
                <h5>Time Out</h5>
                <?php 
                $getTimeInOrOutForToday = getTimeInOrOutForToday($pdo, $_SESSION['user_id'], date('Y-m-d', strtotime($date)), "time_out");
                if (!empty($getTimeInOrOutForToday)) {
                  echo "<span class='attendance-status status-success'><i class='fas fa-check-circle mr-2'></i>" . 
                       date('h:i A', strtotime($getTimeInOrOutForToday['timestamp_record_added'])) . "</span>";
                } else {
                  echo "<span class='attendance-status status-pending'><i class='fas fa-times-circle mr-2'></i>Not yet recorded</span>";
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </body>
</html>