<?php

if ($level == '1') {
  // super admin header
  ?>

  <nav class="navbar navbar-expand bg-dark navbar-dark">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">HOME</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="add-admin.php">ADD ADMIN USER</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="company-users-list.php">COMPANIES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="student-users-list.php">STUDENTS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin-users-list.php">ADMINS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="conversations-list.php">CONVERSATIONS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="jobs-list.php">JOBS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">PROFILE</a>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item ">
          <a class="nav-link" href="../includes/logout.php">LOGOUT</a>
        </li>
      </ul>
    </div>
  </nav>

<?php
} else {
// admin header
?>

<nav class="navbar navbar-expand bg-dark navbar-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="company-users.php">COMPANIES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="student-users.php">STUDENTS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="jobs.php">JOBS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">PROFILE</a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-right">
      <li class="nav-item ">
        <a class="nav-link" href="../includes/logout.php">LOGOUT</a>
      </li>
    </ul>
  </div>
</nav>

<?php
}
?>
