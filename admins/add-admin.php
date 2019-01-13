<?php

require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/admin-handler.php';

?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Add an admin user</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="../includes/css/forms.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>

<body>

  <?php
  include '../includes/headers/admin-header.php';
  ?>

<h1>Add an admin user...</h1>

<div class="row">
  <div class="col-6">
    <form action="add-admin.php" method="POST">
      <div>
        <label for="registerFirstName">First name: </label>
        <?php echo getError($errorArray, $text2to25); ?>
        <input id="registerFirstName" type="text" name="registerFirstName" placeholder="e.g. Bart" value="<?php getValue('registerFirstName'); ?>" required>
      </div>
      <div>
        <label for="registerLastName">Last name: </label>
        <?php echo getError($errorArray, $text2to25); ?>
        <input id="registerLastName" type="text" name="registerLastName" placeholder="e.g. Simpson" value="<?php getValue('registerLastName'); ?>" required>
      </div>
      <div>
        <label for="registerEmail1">Email: </label>
        <?php echo getError($errorArray, $emTaken); ?>
        <?php echo getError($errorArray, $emInvalid); ?>
        <?php echo getError($errorArray, $text2to100); ?>
        <input id="registerEmail1" type="email" name="registerEmail1" placeholder="e.g. bart@springfield.com" value="<?php getValue('registerEmail1'); ?>" required>
      </div>
      <div>
        <label for="registerEmail2">Confirm email: </label>
        <?php echo getError($errorArray, $emDoNotMatch); ?>
        <input id="registerEmail2" type="email" name="registerEmail2" placeholder="e.g. bart@springfield.com" required>
      </div>
      <div>
          <label for="registerPassword1">Password: </label>
          <?php echo getError($errorArray, $pwWrongLength); ?>
          <input id="registerPassword1" type="password" name="registerPassword1" placeholder="Your password" required>
        </div>
        <div>
          <label for="registerPassword2">Confirm password: </label>
          <?php echo getError($errorArray, $pwDoNotMatch); ?>
          <input id="registerPassword2" type="password" name="registerPassword2" placeholder="Your password" required>
        </div>
      <button type="submit" name="addAdminButton">SIGN UP!</button>
    </form>
  </div>
</div>
</body>
</html>
