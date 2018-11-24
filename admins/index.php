<?php
require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';

echo $_SESSION['adminLoggedIn'];
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HOME</title>
  </head>
  <body>
    <?php
    include '../includes/headers/admin-header.php';
     ?>

  </body>
</html>
