<?php
require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/company-handler.php';
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PROFILE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
      var wantsToOfferWorkExperience = document.getElementById("wantsToOfferWorkExperience").value;

      if (wantsToOfferWorkExperience == 'yes') {
        console.log('yes');
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);
      } else {
        console.log('no');
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
      // $we = 'no';
      $weDescription = $row['companyWorkExperienceDescription'];
      $weRequirements = $row['companyWorkExperienceRequirements'];
      $encryptedPassword = $row['companyPassword'];
      $signUp = $row['companySignUpDate'];
    } else {
      echo 'query error';
    }

    ?>

    <form action="profile.php" method="post">
      <p>
        <label for="name">Company Name: </label>
        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="e.g. Krusty Krabby">
      </p>
      <p>
        <label for="email">Email address: </label>
        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="e.g. krusty@krabby.com">
      </p>
      <p>
        <label for="about">About your company:</label>
        <input type="text" name="about" value="<?php echo $about; ?>">
      </p>
      <input type="submit" name="updateDetails" value="Update company details">
    </form>

    <br>

    <form action="profile.php" method="post">
      <p>
        <label for="oldPassword">Enter your current password: </label>
        <input type="password" name="oldPassword">
      </p>
      <p>
        <label for="newPassword1">Enter your new password: </label>
        <input type="password" name="newPassword1">
      </p>
      <p>
        <label for="newPassword2">Confirm your password: </label>
        <input type="password" name="newPassword2">
      </p>
      <input type="submit" name="updatePassword" value="Change password">
    </form>

    <br>

    <form action="profile.php" method="post">
      <input id="wantsToOfferWorkExperience" type="hidden" name="wantsToOfferWorkExperience" value="<?php echo $we; ?>">

      <div id="yesWorkExperience" hidden>
      <p>
        <label for="description"> Work Experience Description:</label>
        <input id="description" type="text" name="description" value="<?php echo $weDescription; ?>">
      </p>
      <p>
        <label for="description"> Work Experience Requirements:</label>
        <input id="requirements" type="text" name="requirements" value="<?php echo $weRequirements; ?>">
      </p>
      <input id="updateWorkExperienceBtn" type="submit" name="updateWorkExperienceBtn" value="Update work experience details">
      <input id="noWorkExperienceBtn" type="submit" name="noWorkExperienceBtn" value="We don't want to offer work experience">
      </div>

      <div id="noWorkExperience" hidden>
        <button id="yesWorkExperienceBtn" type="button" name="yesWorkExperienceBtn">We want to offer work experience</button>
      </div>

    </form>

  </body>
</html>
