<?php

// VARIABLES
$errorArray = array();

// HELPER FUNCTIONS
function getIDFromEmail($con, $email) {
    $sql_query = "SELECT companyID FROM companies WHERE companyEmailAddress = '$email'";
    $result = mysqli_query($con, $sql_query);

    if (($result->num_rows) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["companyID"];
    } else {
        echo "Problem getting ID";
    }
}

function getError($errorArray, $error) {
    if (!in_array($error, $errorArray)) {
        $error = "";
    }
    return "<span class='errorMessage'>$error</span>";
}

// SANITIZATION FUNCTIONS
function sanitizeCompanyName($companyNameText) {
    $companyNameText = strip_tags($companyNameText);
    // do stuff
    return $companyNameText;
}

function sanitizeString($stringText) {
    $stringText = strip_tags($stringText);
    $stringText = str_replace(" ", "", $stringText);
    return $stringText;
}

function sanitizePassword($passwordText) {
    $passwordText = strip_tags($passwordText);
    return $passwordText;
}

function sanitizeLongText($text) {
  return $text;
}

// VALIDATION FUNCTIONS
function validateCompanyName($errorArray, $companyName) {
  return $errorArray;
}

function validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $email1, $email2) {
    if ($email1 != $email2) {
        array_push($errorArray, $emDoNotMatch);
        return;
    }
    $sql = "
    SELECT companyEmailAddress
    FROM companies
    WHERE companyEmailAddress = '$email1'
    ";
    $checkUniqueQuery = mysqli_query($con, $sql);
    if ($checkUniqueQuery->num_rows > 0) {
        array_push($errorArray, $emTaken);
    }
    else if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        array_push($errorArray, $emInvalid);
    }
    return $errorArray;
}

function validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $email) {
    $sql = "
    SELECT companyEmailAddress
    FROM companies
    WHERE companyEmailAddress = '$email1' AND companyID != '$uid'
    ";
    $checkUniqueQuery = mysqli_query($con, $sql);
    if ($checkUniqueQuery->num_rows > 0) {
        array_push($errorArray, $emTaken);
    };
    if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        array_push($errorArray, $emInvalid);
    };
    return $errorArray;
};

function validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2) {
    if ($password1 != $password2) {
        array_push($errorArray, $pwDoNotMatch);
    }
    else if (strlen($password1) > 20 || strlen($password1) < 6) {
        array_push($errorArray, $pwWrongLength);
    }
    return $errorArray;
}

function validateCurrentPassword($con, $errorArray, $password) {
  $encryptedPw = md5($password);
  $uid = $_SESSION['id'];
  $sql = "
  SELECT companyID, companyPassword
  FROM companies
  WHERE companyID = $uid AND companyPassword = '$encryptedPw'
  ";
  $result = $con->query($sql);
  if ($result->num_rows != 1) {
    array_push($errorArray, "That is not your current password.");
  }
  return $errorArray;
}

function validateLoginDetails($con, $errorArray, $email, $password) {
    $sql = "
    SELECT *
    FROM companies
    WHERE companyEmailAddress = '$email' and companyPassword = '$password'
    ";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows != 1) {
      array_push($errorArray, $loginFailure);;
    }
    return $errorArray;
}

function validateLongText($errorArray, $longText) {
  return $errorArray;
}

// COMPANY TRIED TO LOGIN
if (isset($_POST['loginButton'])) {
    $email = sanitizeString($_POST['loginEmail']);
    $password = sanitizePassword($_POST['loginPassword']);
    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $email, $encryptedPassword);
    if (empty($errorArray)) {
      $_SESSION['companyLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $email);
      echo $_SESSION['companyLoggedIn'];
      echo $_SESSION['id'];
      header('Location: ../companies/index.php');
    }
}

// REGISTER BUTTON PRESSED
if (isset($_POST['registerButton'])) {

    $companyName = sanitizeString($_POST['registerCompanyName']);
    $email1 = sanitizeString($_POST['registerEmail1']);
    $email2 = sanitizeString($_POST['registerEmail2']);
    $password1 = sanitizePassword($_POST['registerPassword1']);
    $password2 = sanitizePassword($_POST['registerPassword2']);
    $about = sanitizeLongText($_POST['about']);
    $we = $_POST['yesNoVal'];

    $errorArray = validateCompanyName($errorArray, $companyName);
    $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $email1, $email2);
    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);
    $errorArray = validateLongText($errorArray, $about);

    if ($we == 'yes') {
      $description = sanitizeLongText($_POST['description']);
      $requirements = sanitizeLongText($_POST['requirements']);

      $errorArray = validateLongText($errorArray, $description);
      $errorArray = validateLongText($errorArray, $requirements);

    } else {
      $description = '';
      $requirements = '';
    }
    echo $errorArray[0];

    if (empty($errorArray)) {
        $encryptedPw = md5($password1);
        $signUpDate = date("Y-m-d");
        $sql = "
        INSERT INTO companies(companyName, companyEmailAddress, companyPassword, companyAbout, companyOffersWorkExperience, companyWorkExperienceDescription, companyWorkExperienceRequirements, companySignUpDate)
        VALUES('$companyName', '$email1', '$encryptedPw', '$about', '$we', '$description', '$requirements', '$signUpDate')
        ";
        if (mysqli_query($con, $sql)) {
          $_SESSION['companyLoggedIn'] = $email1;
          $_SESSION['id'] = getIDFromEmail($con, $email1);
          header('Location: ../companies/index.php');
        }
      }
}

// COMPANY TRIED TO UPDATE DETAILS
if (isset($_POST['updateDetails'])) {

  $name = sanitizeString($_POST['name']);
  $email = sanitizeString($_POST['email']);

  $errorArray = validateCompanyName($errorArray, $name);
  $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $email, $email);
  // echo "*** companyID: " . $uid . " *** companyName: " . $name . " *** companyEmailAddress: " . $email . "***";
  if (empty($errorArray)) {
    $sql = "
    UPDATE companies
    SET companyName = '$name',
    companyEmailAddress = '$email'
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

  $oldPW = sanitizePassword($_POST['oldPassword']);
  $newPW1 = sanitizePassword($_POST['newPassword1']);
  $newPW2 = sanitizePassword($_POST['newPassword2']);

  $errorArray = validateCurrentPassword($con, $errorArray, $oldPW);

  if (empty($errorArray)) {

    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $newPW1, $newPW2);

    if (empty($errorArray)) {

      $encryptedPw = md5($newPW1);
      $sql = "
      UPDATE companies
      SET companyPassword = '$encryptedPw'
      WHERE companyID = '$uid'
      ";
      $result = $con->query($sql);
      if (!$result) {
        echo 'update failure';
      }
    } else {
      echo 'error with new passwords';
    }
  } else {
    echo 'error with old pw';
  }
}

// COMPANY TRIED TO UPDATE WORK EXPERIENCE DETAILS
if (isset($_POST['updateWorkExperienceBtn'])) {

  $description = sanitizeString($_POST['description']);
  $requirements = sanitizeString($_POST['requirements']);

  $errorArray = validateLongText($errorArray, $description);
  $errorArray = validateLongText($errorArray, $requirements);

  if (empty($errorArray)) {
    $sql = "
    UPDATE companies
    SET companyOffersWorkExperience = 'yes',
    companyWorkExperienceDescription = '$description',
    companyWorkExperienceRequirements = '$requirements'
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

// COMPANY NO LONGER WANTS TO OFFER WORK EXPERIENCE
if (isset($_POST['noWorkExperienceBtn'])) {
  $sql = "
  UPDATE companies
  SET companyOffersWorkExperience = 'no',
  companyWorkExperienceDescription = '',
  companyWorkExperienceRequirements = ''
  WHERE companyID = '$uid'
  ";
  // echo $sql;
  $result = $con->query($sql);
  if (!$result) {
    echo 'error with insert';
  }
}
