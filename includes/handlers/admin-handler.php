<?php

// VARIABLES
$errorArray = array();
$table = 'admins';

// HELPER FUNCTIONS
// function getIDFromEmail($con, $email) {
//     $getIDQuery = "
//     SELECT adminID
//     FROM admins
//     WHERE adminEmailAddress = '$email'
//     ";
//     $result = $con->query($getIDQuery);
//
//     if (($result->num_rows) > 0) {
//         $row = $result->fetch_assoc();
//         return $row["adminID"];
//     } else {
//         echo "Problem getting ID";
//     }
// }

// function getLevelFromEmail($con, $email) {
//     $getLevelQuery = "
//     SELECT adminLevel
//     FROM admins
//     WHERE adminEmailAddress = '$email'
//     ";
//     $result = $con->query($getLevelQuery);
//
//     if (($result->num_rows) > 0) {
//         $row = $result->fetch_assoc();
//         return $row["adminLevel"];
//     } else {
//         echo "Problem getting ID";
//     }
// }

// function getError($errorArray, $error) {
//     if (!in_array($error, $errorArray)) {
//         $error = "";
//     }
//     return "<span class='errorMessage'>$error</span>";
//
// }

// function getValue($name) {
//     if (isset($_POST[$name])) {
//         echo $_POST[$name];
//     }
// }

// SANITIZATION FUNCTIONS
// function sanitizeName($name) {
//   $name = strip_tags($name);
//   return $name;
// }

// function sanitizeString($stringText) {
//     $stringText = strip_tags($stringText);
//     $stringText = str_replace(" ", "", $stringText);
//     return $stringText;
// }

// function sanitizePassword($passwordText) {
//     $passwordText = strip_tags($passwordText);
//     return $passwordText;
// }

// function sanitizeDate($date) {
//     // Formats date to YYYY-MM-DD
//     return date("Y-m-d", strtotime($date));
// }

// VALIDATION FUNCTIONS

// function validateName($errorArray, $text2to25, $name) {
//     if (strlen($name) > 25 || strlen($name) < 2) {
//         array_push($errorArray, $text2to25);
//     }
//     return $errorArray;
// }

// function validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $text2to100, $email1, $email2) {
//     if ($email1 != $email2) {
//         array_push($errorArray, $emDoNotMatch);
//
//     } else {
//
//         $checkUniqueEmailQuery = "
//         SELECT adminEmailAddress
//         FROM admins
//         WHERE adminEmailAddress = '$email1'
//         ";
//         $result = $con->query($checkUniqueEmailQuery);
//         if ($result->num_rows > 0) {
//             array_push($errorArray, $emTaken);
//
//         } else {
//
//           if (strlen($email1) > 100 || strlen($email1) < 2) {
//               array_push($errorArray, $text2to100);
//           }
//
//           if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
//               array_push($errorArray, $emInvalid);
//           }
//       }
//   }
//   return $errorArray;
// }

// function validateCurrentPassword($con, $errorArray, $pwNotCurrent, $password) {
//   // Checks the password entered is their current password
//   $encryptedPw = md5($password);
//   $uid = $_SESSION['id'];
//   $checkCurrentPasswordQuery = "
//   SELECT adminID, adminPassword
//   FROM admins
//   WHERE adminID = $uid AND adminPassword = '$encryptedPw'
//   ";
//   $result = $con->query($checkCurrentPasswordQuery);
//   if ($result->num_rows != 1) {
//     array_push($errorArray, $pwNotCurrent);
//   }
//   return $errorArray;
// }

// function validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2) {
//   // checks passwords are the same and the correct length
//   if ($password1 != $password2) {
//       array_push($errorArray, $pwDoNotMatch);
//   } else if (strlen($password1) > 20 || strlen($password1) < 6) {
//       array_push($errorArray, $pwWrongLength);
//   }
//   return $errorArray;
// }

// function validateLoginDetails($con, $errorArray, $loginFailure, $email, $password) {
//   $checkLoginQuery = "
//   SELECT adminID
//   FROM admins
//   WHERE adminEmailAddress = '$email' and adminPassword = '$password'
//   ";
//   $query = $con->query($checkLoginQuery);
//   if ($query->num_rows != 1) {
//     array_push($errorArray, $loginFailure);;
//   }
//   return $errorArray;
// }

// LOGIN BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['loginButton'])) {
    $email = sanitizeStringNoSpaces($_POST['loginEmail']);
    $password = sanitizeString($_POST['loginPassword']);

    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $loginFailure, $table, 'adminEmailAddress', 'adminPassword', $email, $encryptedPassword);

    if (empty($errorArray)) {
      $_SESSION['adminLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $table, 'adminID', 'adminEmailAddress', $email);
      $_SESSION['level'] = getLevelFromEmail($con, $table, 'adminLevel', 'adminEmailAddress', $email);
      header('Location: index.php');
    }
}

// REGISTER BUTTON PRESSED ON REGISTER PAGE
if (isset($_POST['addAdminButton'])) {

  $firstName = sanitizeString($_POST['registerFirstName']);
  $lastName = sanitizeString($_POST['registerLastName']);
  $email1 = sanitizeStringNoSpaces($_POST['registerEmail1']);
  $email2 = sanitizeStringNoSpaces($_POST['registerEmail2']);
  $password1 = sanitizeString($_POST['registerPassword1']);
  $password2 = sanitizeString($_POST['registerPassword2']);

  $errorArray = validateTextLength($errorArray, $fnWrongLength, $firstName, 2, 25);
  $errorArray = validateTextLength($errorArray, $lnWrongLength, $lastName, 2, 25);
  $errorArray = validateEmails($con, $errorArray, $emDoNotMatch, $emTaken, $emInvalid, $emWrongLength, $email1, $email2, 'adminEmailAddress');
  $errorArray = validatePasswords($errorArray, $pwDoNotMatch, $pwWrongLength, $password1, $password2);

  if (empty($errorArray)) {
    $encryptedPw = md5($password1);
    $signUpDate = date("Y-m-d");
    $createAdminQuery = "
    INSERT INTO admins(adminFirstName, adminLastName, adminEmailAddress, adminPassword, adminSignUpDate)
    VALUES('$firstName', '$lastName', '$email1', '$encryptedPw', '$signUpDate')
    ";
    if ($con->query($createAdminQuery)) {
      header('Location: index.php');
    }
  }
}

// UPDATE DETAILS BUTTON PRESSED ON PROFILE PAGE
if (isset($_POST['updateDetails'])) {

  $firstName = sanitizeString($_POST['firstName']);
  $lastName = sanitizeString($_POST['lastName']);
  $email = sanitizeStringNoSpaces($_POST['email']);

  $errorArray = validateUserName($errorArray, $fnWrongLength, $firstName);
  $errorArray = validateUserName($errorArray, $lnWrongLength, $lastName);
  $errorArray = validateEmailsUpdate($con, $errorArray, $emTaken, $emInvalid, $emWrongLength, $email, $table, 'adminEmailAddress');

  if (empty($errorArray)) {
    $updateDetailsQuery = "
    UPDATE admins
    SET adminFirstName = '$firstName',
    adminLastName = '$lastName',
    adminEmailAddress = '$email',
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

  $errorArray = validateCurrentPassword($con, $errorArray, $pwNotCurrent, $table, 'adminID', 'adminPassword', $uid, $password);

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

?>
