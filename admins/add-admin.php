<?php

require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/admin-handler.php';

 ?>

<html lang="en" dir="ltr">
  <head>
    <title>EDIT DETAILS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  </head>
  <body>

    <?php
    include '../includes/headers/admin-header.php';
    ?>

    <h1>Add an admin user</h1>

    <form method="POST">

      <div class="row">
        <div class="col">
          <label for="firstName">First name: </label>
          <?php echo getError($errorArray, $fnWrongLength); ?>
          <input id="firstName" type="text" name="firstName" placeholder="e.g. Cisco" value="<?php getValue('firstName'); ?>" required>
        </div>
        <div class="col">
          <label for="lastName">Last name: </label>
          <?php echo getError($errorArray, $lnWrongLength); ?>
          <input id="lastName" type="text" name="lastName" placeholder="e.g. Ramone" value="<?php getValue('lastName'); ?>" required>
        </div>
      </div>

      <div class="col">
        <label for="email1">Email: </label>
        <?php echo getError($errorArray, $emDoNotMatch); ?>
        <?php echo getError($errorArray, $emTaken); ?>
        <?php echo getError($errorArray, $emInvalid); ?>
        <?php echo getError($errorArray, $emWrongLength); ?>
        <input id="email1" type="email" name="email1" placeholder="e.g. cisco@starlabs.com" value="<?php getValue('email1'); ?>" required>
      </div>

      <div class="col">
        <label for="email2">Confirm email: </label>
        <input id="email2" type="email" name="email2" placeholder="e.g. cisco@starlabs.com" required>
      </div>

      <div class="row">
        <div class="col">
          <label for="password1">Password: </label>
          <?php echo getError($errorArray, $pwWrongLength); ?>
          <?php echo getError($errorArray, $pwDoNotMatch); ?>
          <input id="password1" type="password" name="password1" placeholder="Your password" required>
        </div>
        <div class="col">
          <label for="password2">Confirm password: </label>
          <input id="password2" type="password" name="password2" placeholder="Your password" required>
        </div>
      </div>

      <div class="col">
        <button type="submit" name="addAdminButton">ADD!</button>
      </div>

    </form>

  </body>
</html>
