<?php

require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';
include '../includes/handlers/student-handler.php';

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  </head>
  <body>

    <?php
    include '../includes/headers/student-header.php';
    $sql = "
    SELECT studentFirstName, studentLastName, studentEmailAddress, studentPassword, studentDateOfBirth, studentSignUpDate
    FROM students
    WHERE studentID = $uid
    ";

    $result = $con->query($sql);
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $firstName = $row['studentFirstName'];
      $lastName = $row['studentLastName'];
      $email = $row['studentEmailAddress'];
      $encryptedPassword = $row['studentPassword'];
      $dob = $row['studentDateOfBirth'];
      $signUp = $row['studentSignUpDate'];
    } else {
      echo 'query error';
    }


    ?>

    <form class="" action="profile.php" method="post">
      <p>
        <label for="firstName">First Name: </label>
        <input type="text" name="firstName" value="<?php echo $firstName; ?>" placeholder="e.g. Bart">
      </p>
      <p>
        <label for="lastName">Last Name: </label>
        <input type="text" name="lastName" value="<?php echo $lastName; ?>" placeholder="e.g. Simpson">
      </p>
      <p>
        <label for="email">Email address: </label>
        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="e.g. bart@springfield.com">
      </p>
      <p>
        <label for="dob">Date of Birth: </label>
        <input type="date" name="dob" value="<?php echo $dob; ?>">
      </p>
      <input type="submit" name="updateDetails" value="Update">
    </form>


    <br>


    <form class="" action="profile.php" method="post">
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

  </body>
</html>
