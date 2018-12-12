<?php

require '../includes/config.php';
include '../includes/constants.php';
include '../includes/handlers/admin-handler.php';

?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>ADMIN LOG IN</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../includes/css/student-registration.css"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>

<body>
  <div class="" id="background">
    <div id="inputContainer" class="col-6">
      <!-- LOGIN FORM -->
      <form id="loginForm" action="login.php" method="POST">
        <h2>Login to your account...</h2>
        <p>
          <?php
          // echo getError($errorArray, $loginFailure);
          ?>
          <label for="loginEmail">Email: </label>
          <input id="loginEmail" type="text" name="loginEmail" placeholder="e.g. bartsimpson@springfield.com" value="<?php getValue('loginEmail'); ?>" required>
        </p>
        <p>
          <label for="loginPassword">Password: </label>
          <input id="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
        </p>
        <button type="submit" name="loginButton">LOG IN!</button>
        <br><br>
      </form>

    </div>
  </div>

</body>
</html>
