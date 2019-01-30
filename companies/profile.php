<?php
require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/company-handler.php';
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PROFILE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
      var wantsToOfferWorkExperience = document.getElementById("wantsToOfferWorkExperience").value;

      if (wantsToOfferWorkExperience == 'yes') {
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);
      } else {
        $("#noWorkExperience").attr('hidden', false);
        $("#yesWorkExperience").attr('hidden', true);
      }

      $("#yesWorkExperienceBtn").click(function() {
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);

      })
    })




    </script>
  </head>
  <body>

    <?php

    include '../includes/headers/company-header.php';

    $sql = "
    SELECT companyName, companyEmailAddress, companyPassword, companyAbout, companySignUpDate, companyOffersWorkExperience, companyWorkExperienceDescription, companyWorkExperienceRequirements
    FROM companies
    WHERE companyID = $uid
    ";

    $result = $con->query($sql);
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $name = $row['companyName'];
      $email = $row['companyEmailAddress'];
      $about = $row['companyAbout'];
      $we = $row['companyOffersWorkExperience'];
      $weDescription = $row['companyWorkExperienceDescription'];
      $weRequirements = $row['companyWorkExperienceRequirements'];
      $encryptedPassword = $row['companyPassword'];
      $signUp = $row['companySignUpDate'];
    }

    ?>

    <h1>Edit your details</h1>
    <div class="row">
      <div class="col">
        <form action="profile.php" method="post">
          <p>
            <?php echo getError($errorArray, $cnWrongLength); ?>
            <label for="name">Company Name: </label>
            <input type="text" name="name" value="<?php echo $name; ?>" placeholder="e.g. Star Labs">
          </p>
          <p>
            <?php echo getError($errorArray, $emTaken); ?>
            <?php echo getError($errorArray, $emInvalid); ?>
            <label for="email">Email address: </label>
            <input type="text" name="email" value="<?php echo $email; ?>" placeholder="e.g. harry@starlabs.com">
          </p>
          <p>
            <?php echo getError($errorArray, $aboutWrongLength); ?>
            <label for="about">About your company:</label>
            <input type="text" name="about" value="<?php echo $about; ?>">
          </p>
          <input type="submit" name="updateDetails" value="Update company details">
        </form>

        <form action="profile.php" method="post">
          <p>
            <?php echo getError($errorArray, $pwNotCurrent); ?>
            <label for="oldPassword">Enter your current password: </label>
            <input type="password" name="oldPassword">
          </p>
          <p>
            <?php echo getError($errorArray, $pwWrongLength); ?>
            <?php echo getError($errorArray, $pwDoNotMatch); ?>
            <label for="newPassword1">Enter your new password: </label>
            <input type="password" name="newPassword1">
          </p>
          <p>
            <label for="newPassword2">Confirm your password: </label>
            <input type="password" name="newPassword2">
          </p>
          <input type="submit" name="updatePassword" value="Change password">
        </form>

      </div>
      <div class="col">
        <form action="profile.php" method="post">
          <input id="wantsToOfferWorkExperience" type="hidden" name="wantsToOfferWorkExperience" value="<?php echo $we; ?>">
          <div id="yesWorkExperience" hidden>
          <p>
            <?php echo getError($errorArray, $descWrongLength); ?>
            <label for="description"> Work Experience Description:</label>
            <textarea id="description" name="description"><?php echo $weDescription; ?></textarea>
          </p>
          <p>
            <?php echo getError($errorArray, $reqWrongLength); ?>
            <label for="requirements"> Work Experience Requirements:</label>
            <textarea id="requirements" name="requirements"><?php echo $weRequirements; ?></textarea>
          </p>
          <input id="updateWorkExperienceBtn" type="submit" name="updateWorkExperienceBtn" value="Update work experience details">
          <input id="noWorkExperienceBtn" type="submit" name="noWorkExperienceBtn" value="We don't want to offer work experience">
          </div>

          <div id="noWorkExperience" hidden>
            <button id="yesWorkExperienceBtn" type="button" name="yesWorkExperienceBtn">We want to offer work experience</button>
          </div>

        </form>
      </div>

    </div>

  </body>
</html>
