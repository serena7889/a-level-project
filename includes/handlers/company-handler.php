<?php

// VARIABLES
$errorArray = array();
$table = 'companies';
$idField = 'companyID';
$emailField = 'companyEmailAddress';
$passwordField = 'companyPassword';

// COMPANY TRIED TO LOGIN
if (isset($_POST['loginButton'])) {
    $email = sanitizeStringNoSpaces($_POST['loginEmail']);
    $password = sanitizeString($_POST['loginPassword']);

    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $loginFailure, $table, $emailField, $passwordField, $email, $encryptedPassword);

    if (empty($errorArray)) {
      $_SESSION['companyLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $table, $idField, $emailField, $email);
      echo $_SESSION['companyLoggedIn'];
      echo $_SESSION['id'];
      header('Location: ../companies/index.php');
    }
}

// REGISTER BUTTON PRESSED
if (isset($_POST['registerButton'])) {

  $companyName = sanitizeString($_POST['registerCompanyName']);
  $email1 = sanitizeStringNoSpaces($_POST['registerEmail1']);
  $email2 = sanitizeStringNoSpaces($_POST['registerEmail2']);
  $password1 = sanitizeString($_POST['registerPassword1']);
  $password2 = sanitizeString($_POST['registerPassword2']);
  $about = sanitizeString($_POST['about']);
  $we = $_POST['yesNoVal'];

  $errorArray = validateTextLength($errorArray, $cnWrongLength, $companyName, 2, 50);
  $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $emWrongLength, $email1, $email2, $table, $emailField);
  $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);
  $errorArray = validateTextLength($errorArray, $aboutWrongLength, $about, 50, 1000);

  if ($we == 'yes') {
    $description = sanitizeString($_POST['description']);
    $requirements = sanitizeString($_POST['requirements']);

    $errorArray = validateTextLength($errorArray, $descWrongLength, $description, 50, 1000);
    $errorArray = validateTextLength($errorArray, $reqWrongLength, $requirements, 50, 1000);

  } else {

    $description = '';
    $requirements = '';

  }
  print_r($errorArray);
  if (empty($errorArray)) {
    $encryptedPw = md5($password1);
    $signUpDate = date("Y-m-d");
    $createCompanyAccountQuery = "
    INSERT INTO companies(companyName, companyEmailAddress, companyPassword, companyAbout, companyOffersWorkExperience, companyWorkExperienceDescription, companyWorkExperienceRequirements, companySignUpDate)
    VALUES('$companyName', '$email1', '$encryptedPw', '$about', '$we', '$description', '$requirements', '$signUpDate')
    ";
    if ($con->query($createCompanyAccountQuery)) {
      $_SESSION['companyLoggedIn'] = $email1;
      $_SESSION['id'] = getIDFromEmail($con, $table, $idField, $emailField, $email1);
      header('Location: ../companies/index.php');
    }
  }
}

// COMPANY TRIED TO UPDATE DETAILS
if (isset($_POST['updateDetails'])) {

  $name = sanitizeString($_POST['name']);
  $email = sanitizeEmail($_POST['email']);
  $about = sanitizeString($_POST['about']);

  $errorArray = validateTextLength($errorArray, $cnWrongLength, $companyName, 2, 50);
  $errorArray = validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $emWrongLength, $email, $table, $emailField);

  if (empty($errorArray)) {
    $sql = "
    UPDATE companies
    SET companyName = '$name',
    companyEmailAddress = '$email'
    companyAbout = '$about'
    WHERE companyID = '$uid'
    ";
    // echo $sql;
    $result = $con->query($sql);
    if (!$result) {
      echo 'error with insert';
    }
  } else {
    echo 'error: ' . $errorArray[0];
  }
}

// COMPANY TRIED TO UPDATE PASSWORD
if (isset($_POST['updatePassword'])) {

  $oldPW = sanitizeString($_POST['oldPassword']);
  $newPW1 = sanitizeString($_POST['newPassword1']);
  $newPW2 = sanitizeString($_POST['newPassword2']);

  $errorArray = validateCurrentPassword($con, $errorArray, $pwNotCurrent, $table, $idField, $passwordField, $uid, $oldPW);

  if (empty($errorArray)) {

    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);

    if (empty($errorArray)) {

      $encryptedPw = md5($newPW1);
      $updatePasswordQuery = "
      UPDATE companies
      SET companyPassword = '$encryptedPw'
      WHERE companyID = '$uid'
      ";
      $result = $con->query($updatePasswordQuery);
    }
  }
}

// COMPANY TRIED TO UPDATE WORK EXPERIENCE DETAILS
if (isset($_POST['updateWorkExperienceBtn'])) {

  $description = sanitizeString($_POST['description']);
  $requirements = sanitizeString($_POST['requirements']);

  $errorArray = validateTextLength($errorArray, $descWrongLength, $description, 50, 1000);
  $errorArray = validateTextLength($errorArray, $reqWrongLength, $requirements, 50, 1000);

  if (empty($errorArray)) {
    $updateCompanyQuery = "
    UPDATE companies
    SET companyOffersWorkExperience = 'yes',
    companyWorkExperienceDescription = '$description',
    companyWorkExperienceRequirements = '$requirements'
    WHERE companyID = '$uid'
    ";
    // echo $sql;
    $result = $con->query($updateCompanyQuery);
    if (!$result) {
      echo 'error with insert';
    }
  }
}

// COMPANY NO LONGER WANTS TO OFFER WORK EXPERIENCE
if (isset($_POST['noWorkExperienceBtn'])) {
  $updateWorkExperienceQuery = "
  UPDATE companies
  SET companyOffersWorkExperience = 'no',
  companyWorkExperienceDescription = '',
  companyWorkExperienceRequirements = ''
  WHERE companyID = '$uid'
  ";
  // echo $sql;
  $result = $con->query($updateWorkExperienceQuery);
  if (!$result) {
    echo 'error with insert';
  }
}
