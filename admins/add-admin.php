<?php

require '../includes/config.php';
include '../includes/constants.php';
include '../includes/handlers/admin-handler.php';

?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Add an admin user</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../includes/css/student-registration.css"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>

<body>

  <?php
  include '../includes/headers/admin-header.php';
  ?>

  <div class="" id="background">
    <div id="inputContainer" class="col-6">

      <!-- REGISTER FORM -->
      <form id="registerForm" action="add-admin.php" method="POST">
        <h2>Add an admin user...</h2>
        <div class="row">
          <div class="col">
            <?php echo getError($errorArray, $fnWrongLength); ?>
            <label for="registerFirstName">First name: </label>
            <input id="registerFirstName" type="text" name="registerFirstName" placeholder="e.g. Bart" value="<?php getValue('registerFirstName'); ?>" required>
          </div>
          <div class="col">
            <?php echo getError($errorArray, $lnWrongLength); ?>
            <label for="registerLastName">Last name: </label>
            <input id="registerLastName" type="text" name="registerLastName" placeholder="e.g. Simpson" value="<?php getValue('registerLastName'); ?>" required>
          </div>
        </div>
        <div>
          <?php echo getError($errorArray, $emTaken); ?>
          <?php echo getError($errorArray, $emInvalid); ?>
          <label for="registerEmail1">Email: </label>
          <input id="registerEmail1" type="email" name="registerEmail1" placeholder="e.g. bart@springfield.com" value="<?php getValue('registerEmail1'); ?>" required>
        </div>
        <div>
          <?php echo getError($errorArray, $emDoNotMatch); ?>
          <label for="registerEmail2">Confirm email: </label>
          <input id="registerEmail2" type="email" name="registerEmail2" placeholder="e.g. bart@springfield.com" required>
        </div>
        <div class="row">
          <div class="col">
            <?php echo getError($errorArray, $pwWrongLength); ?>
            <label for="registerPassword1">Password: </label>
            <input id="registerPassword1" type="password" name="registerPassword1" placeholder="Your password" required>
          </div>
          <div class="col">
            <?php echo getError($errorArray, $pwDoNotMatch); ?>
            <label for="registerPassword2">Confirm password: </label>
            <input id="registerPassword2" type="password" name="registerPassword2" placeholder="Your password" required>
          </div>
        </div>
        <button type="submit" name="addAdminButton">SIGN UP!</button>
      </form>

    </div>
  </div>

</body>
</html>
