<?php
require '../includes/config.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/student-handler.php';
?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Register or Sign In!</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet">
  <link rel="stylesheet" href="../includes/css/student-registration.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <script>

    $(document).ready(function() {

      <?php
      if (isset($_POST['registerButton'])) {
          ?>
          $('#loginForm').attr('hidden', true);
          $('#registerForm').attr('hidden', false);
      <?php
      } else {
          ?>
          $('#registerForm').attr('hidden', true);
          $('#loginForm').attr('hidden', false);
      <?php
      }
      ?>

      $('#toRegister').click(function() {
        $('#loginForm').attr('hidden', true);
        $('#registerForm').attr('hidden', false);
      });

      $('#toLogin').click(function() {
        $('#registerForm').attr('hidden', true);
        $('#loginForm').attr('hidden', false);
      });

      $('#next').click(function() {
        $('#page1').attr('hidden', true);
        $('#page2').attr('hidden', false);
      });

      $('#back').click(function() {
        $('#page2').attr('hidden', true);
        $('#page1').attr('hidden', false);
      });
    });

    </script>

</head>

<body>

  <div id="background">
    <div id="inputContainer" class="col-6">

      <!-- LOGIN FORM -->
      <form id="loginForm" action="register.php" method="POST" hidden>

        <h2>Login to your account...</h2>

        <p>
          <label for="loginEmail">Email: </label>
          <?php echo getError($errorArray, $loginFailure); ?>
          <input id="loginEmail" type="text" name="loginEmail" placeholder="e.g. flash@starlabs.com" value="<?php getValue('loginEmail'); ?>" required>
        </p>

        <p>
          <label for="loginPassword">Password: </label>
          <input id="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
        </p>

        <button type="submit" name="loginButton">LOG IN!</button>

        <div class="hasAccountText" href="#">
          <span id="toRegister">Don't have an account yet? Click here to register...</span>
          <p>Trouble logging in? <a href="mailto:serenalambert1731@gmail.com?subject=Forgot%20password">Get in touch!</a></p>
        </div>
      </form>


      <!-- REGISTER FORM -->
      <form id="registerForm" method="POST" hidden>

        <div id="page1">

          <h2>Create an account...</h2>

          <div class="row">

            <div class="col">
              <?php echo getError($errorArray, $fnWrongLength); ?>
              <label for="registerFirstName">First name: </label>
              <input id="registerFirstName" type="text" name="registerFirstName" placeholder="e.g. Barry" value="<?php getValue('registerFirstName'); ?>" required>
            </div>

            <div class="col">
              <?php echo getError($errorArray, $lnWrongLength); ?>
              <label for="registerLastName">Last name: </label>
              <input id="registerLastName" type="text" name="registerLastName" placeholder="e.g. Allen" value="<?php getValue('registerLastName'); ?>" required>
            </div>

          </div>

          <div>
            <?php echo getError($errorArray, $emDoNotMatch); ?>
            <?php echo getError($errorArray, $emTaken); ?>
            <?php echo getError($errorArray, $emInvalid); ?>
            <?php echo getError($errorArray, $emWrongLength); ?>
            <label for="registerEmail1">Email: </label>
            <input id="registerEmail1" type="email" name="registerEmail1" placeholder="e.g. flash@starlabs.com" value="<?php getValue('registerEmail1'); ?>" required>
          </div>

          <div>
            <label for="registerEmail2">Confirm email: </label>
            <input id="registerEmail2" type="email" name="registerEmail2" placeholder="e.g. flash@starlabs.com" required>
          </div>

          <div>
            <?php echo getError($errorArray, $pwWrongLength); ?>
            <?php echo getError($errorArray, $pwDoNotMatch); ?>
            <div class="row">
              <div class="col">
                <label for="registerPassword1">Password: </label>
                <input id="registerPassword1" type="password" name="registerPassword1" placeholder="Your password" required>
              </div>

              <div class="col">
                <label for="registerPassword2">Confirm password: </label>
                <input id="registerPassword2" type="password" name="registerPassword2" placeholder="Your password" required>
              </div>
            </div>
          </div>

          <div>
            <?php echo getError($errorArray, $dobInvalid); ?>
            <label for="dateOfBirth">Enter your date of birth: </label>
            <input id="dateOfBirth" name="dateOfBirth" type="date" required>
          </div>

          <button id="next" type="button">NEXT</button>

          <div class="hasAccountText" href="#">
            <span id="toLogin">Already have an account? Click here to login...</span>
          </div>

        </div>

        <div id="page2" hidden>

          <div>
            <label for="cv">Tell companies a bit about yourself:</label>
            <?php echo getError($errorArray, $cvWrongLength); ?>
            <textarea id="cv" class="longText" type="text" name="cv" value="<?php getValue('cv');?>" placeholder="Tell companies a bit about yourself. You could include information about your interests, qualifications, experience..." required></textarea>
          </div>

          <button id="back" type="button">BACK</button>
          <button type="submit" name="registerButton">SIGN UP!</button>
        </div>

      </form>

    </div>
  </div>

</body>
</html>
