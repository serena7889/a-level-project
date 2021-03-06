<?php

require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
$studentID = $_GET['studentID'];
include '../includes/handlers/admin-handler.php';

 ?>

<html lang="en" dir="ltr">
  <head>
    <title>EDIT STUDENT</title>
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
    $getStudentDetailsQuery = "
    SELECT studentFirstName, studentLastName, studentEmailAddress, studentPassword, studentDateOfBirth, studentSignUpDate
    FROM students
    WHERE studentID = '$studentID'
    ";

    $result = $con->query($getStudentDetailsQuery);
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $firstName = $row['studentFirstName'];
      $lastName = $row['studentLastName'];
      $email = $row['studentEmailAddress'];
      $encryptedPassword = $row['studentPassword'];
      $dob = $row['studentDateOfBirth'];
      $signUp = $row['studentSignUpDate'];
    }
    ?>
    <h1>Edit student</h1>

    <div class="row">
      <div class="col">
        <form method="post">
          <p>
            <label for="firstName">First Name: </label>
            <?php echo getError($errorArray, $fnWrongLength);?>
            <input type="text" name="firstName" value="<?php echo $firstName; ?>" placeholder="e.g. Bart">
          </p>
          <p>
            <label for="lastName">Last Name: </label>
            <?php echo getError($errorArray, $lnWrongLength);?>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>" placeholder="e.g. Simpson">
          </p>
          <p>
            <label for="email">Email address: </label>
            <?php echo getError($errorArray, $emWrongLength);?>
            <?php echo getError($errorArray, $emInvalid);?>
            <?php echo getError($errorArray, $emTaken);?>
            <input type="email" name="email" value="<?php echo $email; ?>" placeholder="e.g. bart@springfield.com">
          </p>
          <p>
            <label for="dob">Date of Birth: </label>
            <?php echo getError($errorArray, $dobInvalid);?>
            <input type="date" name="dob" value="<?php echo $dob; ?>">
          </p>
          <input type="submit" name="updateStudentDetails" value="Update">
        </form>
      </div>

      <div class="col">
        <form method="post">
          <p>
            <label for="newPassword1">Enter your new password: </label>
            <?php echo getError($errorArray, $pwWrongLength);?>
            <?php echo getError($errorArray, $pwDoNotMatch);?>
            <input type="password" name="newPassword1">
          </p>
          <p>
            <label for="newPassword2">Confirm your password: </label>
            <input type="password" name="newPassword2">
          </p>
          <input type="submit" name="updateStudentPassword" value="Change password">
        </form>
      </div>

    </div>

  </body>
</html>
