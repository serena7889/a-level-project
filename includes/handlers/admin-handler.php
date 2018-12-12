<?php

// VARIABLES
$errorArray = array();

// HELPER FUNCTIONS
function getIDFromEmail($con, $email) {
    $sql = "SELECT adminID FROM admins WHERE adminEmailAddress = '$email'";
    $result = mysqli_query($con, $sql);

    if (($result->num_rows) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["adminID"];
    } else {
        echo "Problem getting ID";
    }
}

function getLevelFromEmail($con, $email) {
    $sql = "SELECT adminLevel FROM admins WHERE adminEmailAddress = '$email'";
    $result = mysqli_query($con, $sql);

    if (($result->num_rows) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["adminLevel"];
    } else {
        echo "Problem getting ID";
    }
}

function getError($errorArray, $error) {
    // echo 'error';
    if (!in_array($error, $errorArray)) {
        $error = "";
    }
    return "<span class='errorMessage'>$error</span>";
}

function getValue($name) {
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

// SANITIZATION FUNCTIONS
function sanitizeCompanyName($companyNameText) {
    $usernameText = strip_tags($usernameText);
    // do stuff
    return $usernameText;
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

function sanitizeDate($date) {
    // Formats date to YYYY-MM-DD
    return date("Y-m-d", strtotime($date));
}

// VALIDATION FUNCTIONS
function validateFirstName($errorArray, $fnWrongLength, $firstName) {
    // First name length must be between 2 and 50 chars
    if (strlen($firstName) > 50 || strlen($firstName) < 2) {
        array_push($errorArray, $fnWrongLength);
    }
    return $errorArray;
}

function validateLastName($errorArray, $lnWrongLength, $lastName) {
    if (strlen($lastName) > 25 || strlen($lastName) < 2) {
        array_push($errorArray, $lnWrongLength);
    }
    return $errorArray;
}

function validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $email1, $email2) {
    if ($email1 != $email2) {
        array_push($errorArray, $emDoNotMatch);
        return;
    }
    $sql = "SELECT adminEmail FROM admins WHERE adminEmail = '$email1'";
    $checkUniqueQuery = mysqli_query($con, $sql);
    if ($checkUniqueQuery->num_rows > 0) {
        array_push($errorArray, $emTaken);
    }
    else if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        array_push($errorArray, $emInvalid);
    }
    return $errorArray;
}

function validateCurrentPassword($con, $errorArray, $password) {
  $encryptedPw = md5($password);
  $uid = $_SESSION['id'];
  $sql = "
  SELECT adminID, adminPassword
  FROM admins
  WHERE adminID = $uid AND adminPassword = '$encryptedPw'
  ";
  $result = $con->query($sql);
  if ($result->num_rows != 1) {
    array_push($errorArray, "That is not your current password.");
  }
  return $errorArray;
}

function validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2) {
    if ($password1 != $password2) {
        array_push($errorArray, $pwDoNotMatch);
    }
    else if (strlen($password1) > 20 || strlen($password1) < 6) {
        array_push($errorArray, $pwWrongLength);
    }
    return $errorArray;
}

function validateLoginDetails($con, $errorArray, $loginFailure, $email, $password) {
    $sql = "SELECT * FROM admins WHERE adminEmailAddress = '$email' and adminPassword = '$password'";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows != 1) {
      array_push($errorArray, $loginFailure);;
    }
    return $errorArray;
}

// LOGIN BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['loginButton'])) {
    $email = sanitizeString($_POST['loginEmail']);
    $password = sanitizePassword($_POST['loginPassword']);
    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $loginFailure, $email, $encryptedPassword);

    if (empty($errorArray)) {
      $_SESSION['adminLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $email);
      $_SESSION['level'] = getLevelFromEmail($con, $email);
      header('Location: index.php');
    }
}

// REGISTER BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['addAdminButton'])) {

    $firstName = sanitizeString($_POST['registerFirstName']);
    $lastName = sanitizeString($_POST['registerLastName']);
    $email1 = sanitizeString($_POST['registerEmail1']);
    $email2 = sanitizeString($_POST['registerEmail2']);
    $password1 = sanitizePassword($_POST['registerPassword1']);
    $password2 = sanitizePassword($_POST['registerPassword2']);

    $errorArray = validateFirstName($errorArray, $fnWrongLength, $firstName);
    $errorArray = validateLastName($errorArray, $lnWrongLength, $lastName);
    $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $email1, $email2);
    $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);

    if (empty($errorArray)) {
        $encryptedPw = md5($password1);
        $signUpDate = date("Y-m-d");
        $sql = "INSERT INTO admins(adminFirstName, adminLastName, adminEmailAddress, adminPassword, adminSignUpDate) VALUES('$firstName', '$lastName', '$email1', '$encryptedPw', '$signUpDate')";
        if (mysqli_query($con, $sql)) {
          header('Location: index.php');
        }
      }
}

// UPDATE DETAILS BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updateDetails'])) {

  $firstName = sanitizeString($_POST['firstName']);
  $lastName = sanitizeString($_POST['lastName']);
  $email = sanitizeString($_POST['email']);

  $errorArray = validateFirstName($errorArray, $fnWrongLength, $firstName);
  $errorArray = validateLastName($errorArray, $lnWrongLength, $lastName);
  $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $email, $email);
  echo 'error: ' . $errorArray[0];

  if (empty($errorArray)) {
    $sql = "
    UPDATE admins
    SET adminFirstName = '$firstName',
    adminLastName = '$lastName',
    adminEmailAddress = '$email',
    WHERE adminID = '$uid'
    ";
    $result = $con->query($sql);
    if (!$result) {
      echo 'error with insert';
    }
  } else {
    echo 'error with validation';
  }
}

// UPDATE PASSWORD BUTTON PRESSED ON PROFILE PAGE
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
      UPDATE admins
      SET adminPassword = '$encryptedPw'
      WHERE adminID = '$uid'
      ";
      $result = $con->query($sql);
      if ($result) {
        echo 'success';
      } else {
        echo 'update failure';
      }
    } else {
      echo 'error with new passwords';
    }
  } else {
    echo 'error with old pw';
  }
}

?>
