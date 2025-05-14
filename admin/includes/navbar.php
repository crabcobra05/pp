<?php
  // Get unread notifications count
  $unreadCount = countUnreadNotifications($pdo, $_SESSION['user_id']);
  // Get recent notifications
  $notifications = getNotificationsForUser($pdo, $_SESSION['user_id'], 5);
?>
<style>
.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  height: 100vh;
  width: 280px;
  background: linear-gradient(180deg, #004D40 0%, #00695C 100%);
  color: white;
  padding: 1.5rem;
  transition: all 0.3s ease;
  z-index: 1000;
  box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar-header {
  padding: 1.5rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  margin-bottom: 1.5rem;
  text-align: center;
}

.sidebar-brand {
  color: white;
  font-size: 1.75rem;
  font-weight: 600;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0;
  white-space: nowrap;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.sidebar-brand:hover {
  color: white;
  text-decoration: none;
  transform: translateY(-2px);
  transition: transform 0.3s ease;
}

.nav-item {
  margin-bottom: 0.75rem;
}

.nav-link {
  color: rgba(255, 255, 255, 0.8);
  padding: 1rem 1.25rem;
  border-radius: 12px;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
  font-weight: 500;
}

.nav-link:hover {
  color: white;
  background: rgba(255, 255, 255, 0.1);
  transform: translateX(5px);
}

.nav-link.active {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.nav-link i {
  margin-right: 1.25rem;
  width: 24px;
  text-align: center;
  font-size: 1.2rem;
}

.main-content {
  margin-left: 280px;
  padding: 2rem;
  transition: all 0.3s ease;
  min-height: 100vh;
  background: #f8f9fa;
}

.notification-dropdown {
  min-width: 320px;
  padding: 0;
  border-radius: 12px;
  border: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.notification-item {
  padding: 1rem 1.25rem;
  border-bottom: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.notification-item:hover {
  background: #f8f9fa;
}

.notification-item:last-child {
  border-bottom: none;
}

.unread-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #dc3545;
  color: white;
  border-radius: 50%;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
}

.user-section {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(0, 0, 0, 0.1);
}

.user-info {
  display: flex;
  align-items: center;
  color: white;
  padding: 0.75rem 1rem;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.user-info:hover {
  background: rgba(255, 255, 255, 0.1);
}

.user-avatar {
  width: 45px;
  height: 45px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-avatar i {
  font-size: 1.25rem;
}

.user-name {
  font-weight: 600;
  margin-bottom: 0.25rem;
  font-size: 1.1rem;
}

.user-role {
  font-size: 0.875rem;
  opacity: 0.8;
  font-weight: 500;
}

.logout-link {
  display: flex;
  align-items: center;
  color: rgba(255, 255, 255, 0.7);
  padding: 0.75rem 1rem;
  border-radius: 12px;
  margin-top: 0.75rem;
  transition: all 0.3s ease;
  text-decoration: none;
}

.logout-link:hover {
  background: rgba(255, 255, 255, 0.1);
  color: white;
  text-decoration: none;
}

.logout-link i {
  margin-right: 0.75rem;
}

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
</style>

<div class="sidebar">
  <div class="sidebar-header">
    <a href="index.php" class="sidebar-brand">
      <i class="fas fa-shield-alt mr-2"></i>
      Admin Portal
    </a>
  </div>
  
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
        <i class="fas fa-home"></i>
        Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_attendances.php' ? 'active' : ''; ?>" href="all_attendances.php">
        <i class="fas fa-clock"></i>
        Attendance Records
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'leaves.php' ? 'active' : ''; ?>" href="leaves.php">
        <i class="fas fa-calendar-alt"></i>
        Leave Requests
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_users.php' ? 'active' : ''; ?>" href="all_users.php">
        <i class="fas fa-users"></i>
        Employees
      </a>
    </li>
    
    <li class="nav-item dropdown">
      <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell"></i>
        Notifications
        <?php if ($unreadCount > 0): ?>
          <span class="badge badge-danger ml-2"><?php echo $unreadCount; ?></span>
        <?php endif; ?>
      </a>
      <div class="dropdown-menu notification-dropdown" aria-labelledby="notificationDropdown">
        <h6 class="dropdown-header">Notifications</h6>
        <?php if (count($notifications) > 0): ?>
          <?php foreach ($notifications as $notification): ?>
            <a class="dropdown-item notification-item <?php echo $notification['is_read'] ? '' : 'bg-light'; ?>" 
               href="#" onclick="markAsRead(<?php echo $notification['notification_id']; ?>)">
              <?php echo $notification['message']; ?>
              <small class="text-muted d-block">
                <?php echo date('M d, Y h:i A', strtotime($notification['date_added'])); ?>
              </small>
            </a>
          <?php endforeach; ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="#" onclick="markAllAsRead()">Mark all as read</a>
        <?php else: ?>
          <div class="dropdown-item">No notifications</div>
        <?php endif; ?>
      </div>
    </li>
  </ul>

  <div class="user-section">
    <div class="user-info">
      <div class="user-avatar">
        <i class="fas fa-user"></i>
      </div>
      <div>
        <div class="user-name"><?php echo $_SESSION['username']; ?></div>
        <div class="user-role">Administrator</div>
      </div>
    </div>
    <a class="logout-link" href="core/handleForms.php?logoutUserBtn=1">
      <i class="fas fa-sign-out-alt"></i>
      Logout
    </a>
  </div>
</div>

<div class="main-content">