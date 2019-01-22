<?php

// HELPER FUNCTIONS

function getValue($name) {
  // If the form has been submitted, gets the submitted value of an input
  if (isset($_POST[$name])) {
      echo $_POST[$name];
  }
}

function getError($errorArray, $error) {
  // A span is returned showing the specified error if it is in the error array
  if (!in_array($error, $errorArray)) {
      $error = "";
  }
  return '<span class="errorMessage">' . $error . '</span>';
}

function getIDFromEmail($con, $table, $idField, $emailField, $email) {
  // returns the user's ID
  $getIDQuery = "
  SELECT $idField
  FROM $table
  WHERE $emailField = '$email'
  ";
  $result = $con->query($getIDQuery);

  if (($result->num_rows) > 0) {
      $row = $result->fetch_assoc();
      return $row[$idField];
  }
}

function getLevelFromEmail($con, $email) {
  // returns the user's level (admin)
  $getLevelQuery = "
  SELECT adminLevel
  FROM admins
  WHERE adminEmailAddress = '$email'
  ";
  $result = $con->query($getLevelQuery);

  if (($result->num_rows) > 0) {
      $row = $result->fetch_assoc();
      return $row['adminLevel'];
  }
}

function unsetSessionVars() {
  unset($_SESSION['studentLoggedIn']);
  unset($_SESSION['companyLoggedIn']);
  unset($_SESSION['adminLoggedIn']);
  unset($_SESSION['level']);
  unset($_SESSION['id']);
}

// SANITIZATION FUNCTIONS (return sanitized values)

function sanitizeString($string) {
  // returns the string with any tags removed
  $string = strip_tags($string);
  return $string;
}

function sanitizeStringNoSpaces($string) {
  // returns the string with tags and spaces/new line chars etc. removed
  $string = strip_tags($string);
  $string = preg_replace('/\s+/', ' ', $string);
  return $string;
}

function sanitizeDate($date) {
  // returns date formatted to YYYY-MM-DD
  return date("Y-m-d", strtotime($date));
}

// VALIDATION FUNCTIONS (returns errors if relevant)

function validateTextLength($errorArray, $error, $text, $min, $max) {
  // adds the error if the text is longer/shorter than the max/min length specified
  if (strlen($text) > $max || strlen($text) < $min) {
      array_push($errorArray, $error);
  }
  return $errorArray;
}

function validateSame($errorArray, $error, $var1, $var2) {
  // adds error if the two parameters are not the same
  if ($var1 != $var2) {
      array_push($errorArray, $error);
  }
  return $errorArray;
}

function validateUnique($con, $errorArray, $emTaken, $table, $emailField, $email) {
  // adds error if the email has already been registered with that user type
  $checkUniqueQuery = "
  SELECT $emailField
  FROM $table
  WHERE $emailField = '$email' AND $idfield != '$uid'
  ";
  $result = $con->query($checkUniqueQuery);
  if ($result->num_rows > 0) {
      array_push($errorArray, $emTaken);
  }
  return $errorArray;
}

function validateEmailFormat($errorArray, $emInvalid, $email) {
  // adds error if email is in an invalid format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($errorArray, $emInvalid);
  } return $errorArray;
}

function validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $emWrongLength, $email1, $email2, $table, $emailField) {
  // used to validate email with re-entered email
  // adds errors returned from these validation checks
  $errorArray = validateSame($errorArray, $emDoNotMatch, $email1, $email2);
  $errorArray = validateTextLength($errorArray, $emWrongLength, $email1, 2, 100);
  $errorArray = validateEmailFormat($errorArray, $emInvalid, $email1);
  $errorArray = validateUnique($con, $errorArray, $emTaken, $table, $emailField, $email1);
  return $errorArray;
}

function validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $emWrongLength, $email, $table, $emailField) {
  // used to validate email single email
  // adds errors returned from these validation checks
  $errorArray = validateTextLength($errorArray, $emWrongLength, $email, 2, 100);
  $errorArray = validateEmailFormat($errorArray, $emInvalid, $email);
  $errorArray = validateUnique($con, $errorArray, $emTaken, $table, $emailField, $email);
  return $errorArray;
}

function validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2) {
  // used to validate password with re-entered password
  // adds errors returned from these validation checks
  $errorArray = validateSame($errorArray, $pwDoNotMatch, $password1, $password2);
  $errorArray = validateTextLength($errorArray, $pwWrongLength, $password1, 6, 20);
  return $errorArray;
}

function validateCurrentPassword($con, $errorArray, $pwNotCurrent, $table, $idField, $passwordField, $uid, $password) {
  // adds error if password is not user's current password
  $encryptedPw = md5($password);
  $checkCurrentPasswordQuery = "
  SELECT $idField
  FROM $table
  WHERE $idField = '$uid' AND $passwordField = '$encryptedPw'
  ";
  echo $checkCurrentPasswordQuery;
  $result = $con->query($checkCurrentPasswordQuery);
  if ($result->num_rows != 1) {
    array_push($errorArray, $pwNotCurrent);
  }
  return $errorArray;
}

function validateLoginDetails($con, $errorArray, $loginFailure, $table, $emailField, $passwordField, $email, $encryptedPassword) {
    $loginStudentQuery = "
    SELECT $emailField
    FROM $table
    WHERE $emailField = '$email' and $passwordField = '$encryptedPassword'";
    $result = $con->query($loginStudentQuery);
    if ($result->num_rows != 1) {
      array_push($errorArray, $loginFailure);
    }
    return $errorArray;
}

?>
