<?php

// VARIABLES
$errorArray = array();
$table = 'students';
$idField = 'studentID';
$emailField = 'studentEmailAddress';
$passwordField = 'studentPassword';

// LOGIN BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['loginButton'])) {
    $email = sanitizeStringNoSpaces($_POST['loginEmail']);
    $password = sanitizeString($_POST['loginPassword']);

    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $loginFailure, $table, $emailField, $passwordField, $email, $encryptedPassword);

    if (empty($errorArray)) {
      $_SESSION['studentLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $table, $idField, $emailField, $email);
      header('Location: index.php');
    }
}

// REGISTER BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['registerButton'])) {

  $firstName = sanitizeString($_POST['registerFirstName']);
  $lastName = sanitizeString($_POST['registerLastName']);
  $email1 = sanitizeStringNoSpaces($_POST['registerEmail1']);
  $email2 = sanitizeStringNoSpaces($_POST['registerEmail2']);
  $password1 = sanitizeString($_POST['registerPassword1']);
  $password2 = sanitizeString($_POST['registerPassword2']);
  $dob = sanitizeDate($_POST['dateOfBirth']);
  $cv = sanitizeString($_POST['cv']);

  $errorArray = validateTextLength($errorArray, $fnWrongLength, $firstName, 2, 25);
  $errorArray = validateTextLength($errorArray, $lnWrongLength, $lastName, 2, 25);
  $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $emWrongLength, $email1, $email2, $table, $emailField);
  $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);
  $errorArray = validateTextLength($errorArray, $cvWrongLength, $cv, 50, 1000);

  if (empty($errorArray)) {

    $encryptedPw = md5($password1);
    $signUpDate = date("Y-m-d");
    $registerStudentQuery = "
    INSERT INTO students(studentFirstName, studentLastName, studentEmailAddress, studentPassword, studentDateOfBirth, studentSignUpDate, studentCV)
    VALUES('$firstName', '$lastName', '$email1', '$encryptedPw', '$dob', '$signUpDate', '$cv')
    ";
    if ($con->query($registerStudentQuery)) {
      $_SESSION['studentLoggedIn'] = $email1;
      $_SESSION['id'] = getIDFromEmail($con, $table, $idField, $emailField, $email1);
      header('Location: index.php');
    }
  }
}

// UPDATE DETAILS BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updateDetails'])) {

  $firstName = sanitizeString($_POST['firstName']);
  $lastName = sanitizeString($_POST['lastName']);
  $email = sanitizeStringNoSpaces($_POST['email']);
  $dob = sanitizeDate($_POST['dob']);

  $errorArray = validateTextLength($errorArray, $fnWrongLength, $firstName, 2, 25);
  $errorArray = validateTextLength($errorArray, $lnWrongLength, $lastName, 2, 25);
  $errorArray = validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $emWrongLength, $email, $table, $emailField);

  if (empty($errorArray)) {
    $updateStudentQuery = "
    UPDATE students
    SET studentFirstName = '$firstName',
    studentLastName = '$lastName',
    studentEmailAddress = '$email',
    studentDateOfBirth = '$dob'
    WHERE studentID = '$uid'
    ";
    $result = $con->query($updateStudentQuery);
    $_SESSION['studentLoggedIn'] = $email;
  }
}

// UPDATE PASSWORD BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updatePassword'])) {

  $oldPW = sanitizeString($_POST['oldPassword']);
  $newPW1 = sanitizeString($_POST['newPassword1']);
  $newPW2 = sanitizeString($_POST['newPassword2']);

  $errorArray = validateCurrentPassword($con, $errorArray, $pwNotCurrent, $table, $idField, $passwordField, $uid, $oldPW);

  if (empty($errorArray)) {

    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $newPW1, $newPW2);

    if (empty($errorArray)) {
      $encryptedPw = md5($newPW1);
      $updateStudentQuery = "
      UPDATE students
      SET studentPassword = '$encryptedPw'
      WHERE studentID = '$uid'
      ";
      $result = $con->query($updateStudentQuery);
    }
  }
}
