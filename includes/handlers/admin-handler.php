<?php

// VARIABLES
$errorArray = array();
$table = 'admins';
$idField = 'adminID';
$emailField = 'adminEmailAddress';
$passwordField = 'adminPassword';

// LOGIN BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['loginButton'])) {
    $email = sanitizeStringNoSpaces($_POST['loginEmail']);
    $password = sanitizeString($_POST['loginPassword']);

    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $loginFailure, $table, $emailField, $passwordField, $email, $encryptedPassword);

    if (empty($errorArray)) {
      unsetSessionVars();
      $_SESSION['adminLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $table, $idField, $emailField, $email);
      $_SESSION['level'] = getLevelFromEmail($con, $email);
      header('Location: index.php');
    }
}

// REGISTER BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['addAdminButton'])) {

  $firstName = sanitizeString($_POST['firstName']);
  $lastName = sanitizeString($_POST['lastName']);
  $email1 = sanitizeStringNoSpaces($_POST['email1']);
  $email2 = sanitizeStringNoSpaces($_POST['email2']);
  $password1 = sanitizeString($_POST['password1']);
  $password2 = sanitizeString($_POST['password2']);
  echo '1: ' . $password1 . ' ' . '2: ' . $password2;

  $errorArray = validateTextLength($errorArray, $fnWrongLength, $firstName, 2, 25);
  $errorArray = validateTextLength($errorArray, $lnWrongLength, $lastName, 2, 25);
  $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $emWrongLength, $email1, $email2, $table, $emailField);
  $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);

  if (empty($errorArray)) {
    print_r($errorArray);
    $encryptedPw = md5($password1);
    $signUpDate = date("Y-m-d");
    $createAdminQuery = "
    INSERT INTO admins(adminFirstName, adminLastName, adminEmailAddress, adminPassword, adminSignUpDate)
    VALUES('$firstName', '$lastName', '$email1', '$encryptedPw', '$signUpDate')
    ";
    echo $createAdminQuery;
    if ($con->query($createAdminQuery)) {
      header('Location: admins.php');
    }
  }
}

// UPDATE DETAILS BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updateDetails'])) {

  $firstName = sanitizeString($_POST['firstName']);
  $lastName = sanitizeString($_POST['lastName']);
  $email = sanitizeStringNoSpaces($_POST['email']);

  $errorArray = validateTextLength($errorArray, $fnWrongLength, $firstName, 2, 25);
  $errorArray = validateTextLength($errorArray, $lnWrongLength, $lastName, 2, 25);
  $errorArray = validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $emWrongLength, $email, $table, $emailField);

  if (empty($errorArray)) {
    $updateDetailsQuery = "
    UPDATE admins
    SET adminFirstName = '$firstName',
    adminLastName = '$lastName',
    adminEmailAddress = '$email'
    WHERE adminID = '$uid'
    ";
    $result = $con->query($updateDetailsQuery);
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
      $updatePasswordQuery = "
      UPDATE admins
      SET adminPassword = '$encryptedPw'
      WHERE adminID = '$uid'
      ";
      $result = $con->query($updatePasswordQuery);
    }
  }
}

// UPDATE COMPANY DETAILS
if (isset($_POST['updateCompanyDetails'])) {
  $name = sanitizeString($_POST['name']);
  $email = sanitizeStringNoSpaces($_POST['email']);
  $about = sanitizeString($_POST['about']);

  $errorArray = validateTextLength($errorArray, $cnWrongLength, $name, 2, 50);
  $errorArray = validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $emWrongLength, $email, $table, $emailField);

  if (empty($errorArray)) {
    $updateDetailsQuery = "
    UPDATE companies
    SET companyName = '$name',
    companyEmailAddress = '$email',
    companyAbout = '$about'
    WHERE companyID = '$companyID'
    ";
    $result = $con->query($updateDetailsQuery);
  }
}

// COMPANY TRIED TO UPDATE PASSWORD
if (isset($_POST['updateCompanyPassword'])) {

  $oldPW = sanitizeString($_POST['oldPassword']);
  $newPW1 = sanitizeString($_POST['newPassword1']);
  $newPW2 = sanitizeString($_POST['newPassword2']);

  $errorArray = validateCurrentPassword($con, $errorArray, $pwNotCurrent, 'companies', 'companyID', 'companyPassword', $companyID, $oldPW);

  if (empty($errorArray)) {

    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $newPW1, $newPW2);

    if (empty($errorArray)) {

      $encryptedPw = md5($newPW1);
      $updatePasswordQuery = "
      UPDATE companies
      SET companyPassword = '$encryptedPw'
      WHERE companyID = '$companyID'
      ";
      $result = $con->query($updatePasswordQuery);
    }
  }
}

// COMPANY TRIED TO UPDATE WORK EXPERIENCE DETAILS
if (isset($_POST['updateCompanyWorkExperienceBtn'])) {

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
    WHERE companyID = '$companyID'
    ";
    $result = $con->query($updateCompanyQuery);
  }
}

// COMPANY NO LONGER WANTS TO OFFER WORK EXPERIENCE
if (isset($_POST['noWorkExperienceBtn'])) {
  $updateWorkExperienceQuery = "
  UPDATE companies
  SET companyOffersWorkExperience = 'no',
  companyWorkExperienceDescription = '',
  companyWorkExperienceRequirements = ''
  WHERE companyID = '$companyID'
  ";
  $result = $con->query($updateWorkExperienceQuery);
}

// UPDATE DETAILS BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updateStudentDetails'])) {

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
    WHERE studentID = '$studentID'
    ";
    echo $updateStudentQuery;
    $result = $con->query($updateStudentQuery);
    $_SESSION['studentLoggedIn'] = $email;
  }
}

// UPDATE PASSWORD BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updateStudentPassword'])) {

  $oldPW = sanitizeString($_POST['oldPassword']);
  $newPW1 = sanitizeString($_POST['newPassword1']);
  $newPW2 = sanitizeString($_POST['newPassword2']);

  $errorArray = validateCurrentPassword($con, $errorArray, $pwNotCurrent, 'students', 'studentID', 'studentPassword', $studentID, $oldPW);

  if (empty($errorArray)) {

    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $newPW1, $newPW2);

    if (empty($errorArray)) {
      $encryptedPw = md5($newPW1);
      $updateStudentQuery = "
      UPDATE students
      SET studentPassword = '$encryptedPw'
      WHERE studentID = '$studentID'
      ";
      $result = $con->query($updateStudentQuery);
    }
  }
}

if (isset($_POST['deleteJobButton'])) {

  $jobID = $_POST['jobID'];

  $setOldInactiveQuery = "
  UPDATE jobs
  SET jobActive = 'no'
  WHERE jobID = '$jobID';
  ";
  if ($con->query($setOldInactiveQuery)) {
    header("Location: jobs-list.php");
  }

}

if (isset($_POST['updateJobButton'])) {

  $jobID = $_POST['jobID'];

  $setOldInactiveQuery = "
  UPDATE jobs
  SET jobActive = 'no'
  WHERE jobID = '$jobID';
  ";
  $con->query($setOldInactiveQuery);

  $jobTitle = sanitizeString($_POST['jobTitle']);
  $jobDescription = sanitizeString($_POST['jobDescription']);
  $jobRequirements = sanitizeString($_POST['jobRequirements']);
  $jobWages = sanitizeString($_POST['jobWages']);
  $jobTimings = sanitizeString($_POST['jobTimings']);
  $jobLocation= sanitizeString($_POST['jobLocation']);

  $errorArray = validateTextLength($errorArray, $jobTitleLength, $jobTitle, 2, 100);
  $errorArray = validateTextLength($errorArray, $jobDescriptionLength, $jobDescription, 50, 1000);
  $errorArray = validateTextLength($errorArray, $jobRequirementsLength, $jobRequirements, 50, 1000);
  $errorArray = validateTextLength($errorArray, $jobWagesLength, $jobWages, 2, 100);
  $errorArray = validateTextLength($errorArray, $jobTimingsLength, $jobTimings, 2, 100);
  $errorArray = validateTextLength($errorArray, $jobLocationLength, $jobLocation, 2, 100);

  if (empty($errorArray)) {

    $getJobCompanyIDQuery = "SELECT jobCompanyID FROM jobs WHERE jobID = '$jobID'";
    $result = $con->query($getJobCompanyIDQuery);
    if ($result->num_rows == 1) {

      $row = $result-> fetch_assoc();
      $companyID = $row['jobCompanyID'];

      $addNewVersionQuery = "
      INSERT INTO jobs(jobCompanyID, jobTitle, jobDescription, jobRequirements, jobWages, jobTimings, jobLocation)
      VALUES('$companyID', '$jobTitle', '$jobDescription', '$jobRequirements', '$jobWages', '$jobTimings', '$jobLocation')
      ";
      if ($con->query($addNewVersionQuery)) {
        header("Location: jobs-list.php");
      }

    }
  }
}


?>
