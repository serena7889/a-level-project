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

// function sanitizeDate($dob) {
//     // Formats date to YYYY-MM-DD
//     return date("Y-m-d", strtotime($dob));
// }

// VALIDATION FUNCTIONS
// function validateFirstName($errorArray, $firstName) {
//     // First name length must be between 2 and 50 chars
//     if (strlen($firstName) > 50 || strlen($firstName) < 2) {
//         array_push($errorArray, Constants::$fnWrongLength);
//     }
//     return $errorArray;
// }

// function validateLastName($errorArray, $lastName) {
//     if (strlen($lastName) > 25 || strlen($lastName) < 2) {
//         array_push($errorArray, Constants::$lnWrongLength);
//     }
//     return $errorArray;
// }

function validateCompanyName() {

}

function validateEmails($con, $errorArray, $email1, $email2) {
    if ($email1 != $email2) {
        array_push($errorArray, Constants::$emDoNotMatch);
        return;
    }
    $sql = "SELECT studentEmail FROM students WHERE studentEmail = '$email1'";
    $checkUniqueQuery = mysqli_query($con, $sql);
    if ($checkUniqueQuery->num_rows > 0) {
        array_push($errorArray, Constants::$emTaken);
    }
    else if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        array_push($errorArray, Constants::$emInvalid);
    }
    return $errorArray;
}

function validatePasswords($errorArray, $password1, $password2) {
    if ($password1 != $password2) {
        array_push($errorArray, Constants::$pwDoNotMatch);
    }
    else if (strlen($password1) > 20 || strlen($password1) < 6) {
        array_push($errorArray, Constants::$pwWrongLength);
    }
    return $errorArray;
}

function validateLoginDetails($con, $errorArray, $email, $password) {
    $sql = "SELECT * FROM companies WHERE companyEmailAddress = '$email' and companyPassword = '$password'";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows != 1) {
      array_push($errorArray, Constants::$loginFailure);;
    }
    return $errorArray;
}


// LOGIN BUTTON PRESSED
if (isset($_POST['loginButton'])) {
    $email = sanitizeString($_POST['loginEmail']);
    $password = sanitizePassword($_POST['loginPassword']);
    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $email, $encryptedPassword);

    if (empty($errorArray)) {
      $_SESSION['companyLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $email);
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

    $errorArray = validateCompanyName($errorArray, $companyName);
    $errorArray = validateEmails($con, $errorArray, $email1, $email2);
    $errorArray = validatePasswords($errorArray, $password1, $password2);

    if (empty($errorArray)) {
        // return insertStudentDetails($con, $fn, $ln, $em1, $pw1, $dob);
        $encryptedPw = md5($password1);
        $signUpDate = date("Y-m-d");
        $sql = "INSERT INTO companies(companyName, companyEmailAddress, companyPassword, companySignUpDate) VALUES('$companyName', '$email', '$encryptedPw', '$signUpDate')";
        if (mysqli_query($con, $sql)) {
          $_SESSION['companyLoggedIn'] = $email1;
          $_SESSION['id'] = getIDFromEmail($con, $email1);
          header('Location: ../company/index.php');
        }
      }
}
