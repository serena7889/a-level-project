<?php

require '../includes/config.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/company-handler.php';

?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Register or Sign In!</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet">
  <link rel="stylesheet" href="../includes/css/company-registration.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
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

      $('#yesWE').click(function() {
        $('#yesNoVal').attr('value', 'yes');
        $('#noWE').removeClass('selectedButton');
        $('#yesWE').addClass('selectedButton');
        $("#weInputs").attr('hidden', false);
        $('#description').attr('required', true);
        $('#requirements').attr('required', true);
      });

      $('#noWE').click(function() {
        $('#yesNoVal').attr('value', 'no');
        $('#yesWE').removeClass('selectedButton');
        $('#noWE').addClass('selectedButton');
        $("#weInputs").attr('hidden', true);
        $('#description').attr('required', false);
        $('#requirements').attr('required', false);
      })
    });

    // If user has tried to register, automatically shows register
    // page with errors on rather than going to login page

    </script>

</head>

<body>
  <div id="background">
    <div id="inputContainer" class="col-6">

      <!-- LOGIN FORM -->
      <form id="loginForm" class="scrollable" action="register.php" method="POST">

        <h2>Login to your account...</h2>

        <p>
          <?php echo getError($errorArray, $loginFailure); ?>
          <label for="loginEmail">Email: </label>
          <input id="loginEmail" type="text" name="loginEmail" placeholder="e.g. harry@starlabs.com" value="<?php getValue('loginEmail'); ?>" required>
        </p>

        <p>
          <label for="loginPassword">Password: </label>
          <input id="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
        </p>

        <button type="submit" name="loginButton">LOG IN!</button>

        <br><br>

        <div class="hasAccountText" href="#">
          <span id="toRegister">Don't have an account yet? Click here to register...</span>
        </div>

      </form>

      <!-- REGISTER FORM -->
      <form id="registerForm" class="scrollable" action="register.php" method="POST" hidden>
        <div id="page1">

          <h2>Create an account...</h2>

          <div>
            <?php echo getError($errorArray, $cnWrongLength); ?>
            <label for="registerCompanyName">Company name: </label>
            <input id="registerCompanyName" type="text" name="registerCompanyName" placeholder="e.g. Star Labs" value="<?php getValue('registerCompanyName'); ?>" required>
          </div>

          <div>
            <?php echo getError($errorArray, $emTaken); ?>
            <?php echo getError($errorArray, $emInvalid); ?>
            <label for="registerEmail1">Email: </label>
            <input id="registerEmail1" type="email" name="registerEmail1" placeholder="e.g. harry@starlabs.com" value="<?php getValue('registerEmail1'); ?>" required>
          </div>

          <div>
            <?php echo getError($errorArray, $emDoNotMatch); ?>
            <label for="registerEmail2">Confirm email: </label>
            <input id="registerEmail2" type="email" name="registerEmail2" placeholder="e.g. harry@starlabs.com" required>
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

          <button id="next" type="button">NEXT</button>

          <div class="hasAccountText" href="#">
            <span id="toLogin">Already have an account? Click here to login...</span>
          </div>

        </div>

        <div id="page2" hidden>

          <div>
            <label for="about">About your company:</label>
            <textarea id="about" class="longText" type="text" name="about" value="<?php getValue('about'); ?>" placeholder="Tell us about your company! Here is where you can provide any information about your company that would be useful to students... This could include how long you've been around, your companies size, what your company does, what the working environment is like etc. (This will be visible on any opportunities you post)" required></textarea>
          </div>

          <label for="yesNoBtns">Want to offer work experience?</label>
          <div id="yesNoBtns" class="row" name="yesNoBtns">
            <input id="yesNoVal" type="hidden" name="yesNoVal" value="yes">
            <button id="yesWE" type="button" value="yes" class="col selectedButton">YES</button>
            <button id="noWE" type="button" value="no" class="col">NO</button>
          </div>

          <div id="weInputs">

            <div>
              <label for="description">Work experience description:</label>
              <textarea id="description" class="longText" type="text" name="description" value="<?php getValue('description'); ?>" placeholder="Let students know what sort of opportunities you can offer. Maybe include what roles they could have, what they could spend time doing, etc." required></textarea>
            </div>

            <div>
              <label for="requirements">Work experience requirements:</label>
              <textarea id="requirements" class="longText" type="text" name="requirements" value="<?php getValue('requirements'); ?>" placeholder="What are you looking for in a student doing work experience with you? This could be character traits, age, qualifications, interests etc." required></textArea>
            </div>

          </div>

          <button id="back" type="button">BACK</button>
          <button type="submit" name="registerButton">SIGN UP!</button>

        </div>

      </form>

    </div>

  </div>

</body>
</html>
