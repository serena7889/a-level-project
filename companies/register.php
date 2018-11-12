<?php

include '../includes/config.php';
include '../includes/classes/Constants.php';
include '../includes/handlers/company-registration-handler.php';

function getValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Register or Sign In!</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Roboto" rel="stylesheet">
  <link rel="stylesheet" href="../includes/css/company-registration.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <script>
    // Hides / shows forms when propmt clicked
    $(document).ready(function() {
    	$("#hideLogin").click(function() {
    		$("#loginForm").hide();
    		$("#registerForm").show();
    	});
    	$("#hideRegister").click(function() {
    		$("#registerForm").hide();
    		$("#loginForm").show();
    	});
    });

    <?php
    if (isset($_POST['registerButton'])) {
        ?>
  		$(document).ready(function() {
  			$('#loginForm').hide();
  			$('#registerForm').show();
  		});
    <?php
    } else {
        ?>
  		$(document).ready(function() {
  			$('#registerForm').hide();
  			$('#loginForm').show();
  		});
    <?php
    }
    ?>

    </script>

</head>

<body>
  <div class="" id="background">
    <div id="inputContainer" class="col-6">

      <!-- LOGIN FORM -->
      <form id="loginForm" action="register.php" method="POST">
        <h2>Login to your account...</h2>
        <p>
          <?php echo getError($errorArray, Constants::$loginFailure); ?>
          <label for="loginEmail">Email: </label>
          <input id="loginEmail" type="text" name="loginEmail" placeholder="e.g. krustykrabby@springfield.com" value="<?php getValue('loginEmail'); ?>" required>
        </p>
        <p>
          <label for="loginPassword">Password: </label>
          <input id="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
        </p>
        <button type="submit" name="loginButton">LOG IN!</button>
        <br><br>
        <div class="hasAccountText" href="#">
          <span id="hideLogin">Don't have an account yet? Click here to register...</span>
        </div>
      </form>

      <!-- REGISTER FORM -->
      <form id="registerForm" action="register.php" method="POST">
        <h2>Create an account...</h2>
          <div>
            <?php echo getError($errorArray, Constants::$cnWrongLength); ?>
            <label for="registerCompanyName">Company name: </label>
            <input id="registerCompanyName" type="text" name="registerCompanyName" placeholder="e.g. Krusty Krabby" value="<?php getValue('registerCompanyName'); ?>" required>
          </div>
        <div>
          <?php echo getError($errorArray, Constants::$emTaken); ?>
          <?php echo getError($errorArray, Constants::$emInvalid); ?>
          <label for="registerEmail1">Email: </label>
          <input id="registerEmail1" type="email" name="registerEmail1" placeholder="e.g. krustykrabby@springfield.com" value="<?php getValue('registerEmail1'); ?>" required>
        </div>
        <div>
          <?php echo getError($errorArray, Constants::$emDoNotMatch); ?>
          <label for="registerEmail2">Confirm email: </label>
          <input id="registerEmail2" type="email" name="registerEmail2" placeholder="e.g. krustykrabby@springfield.com" required>
        </div>
        <div class="row">
          <div class="col">
            <?php echo getError($errorArray, Constants::$pwWrongLength); ?>
            <label for="registerPassword1">Password: </label>
            <input id="registerPassword1" type="password" name="registerPassword1" placeholder="Your password" required>
          </div>
          <div class="col">
            <?php echo getError($errorArray, Constants::$pwDoNotMatch); ?>
            <label for="registerPassword2">Confirm password: </label>
            <input id="registerPassword2" type="password" name="registerPassword2" placeholder="Your password" required>
          </div>
        </div>
        <button type="submit" name="registerButton">SIGN UP!</button>
        <br><br>
        <div class="hasAccountText" href="#">
          <span id="hideRegister">Already have an account? Click here to login...</span>
        </div>
      </form>

    </div>
  </div>

</body>
</html>
