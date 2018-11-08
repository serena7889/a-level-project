<?php

// FUNCTIONS
function getIDFromEmail($con, $email)
{
    echo '***' . $email . '***';
    $sql_query = "SELECT studentID FROM students WHERE studentEmailAddress = '$email'";
    $result = mysqli_query($con, $sql_query);

    if (($result->num_rows) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["studentID"];
    } else {
        echo "Problem getting ID";
    }
}

function sanitizeCompanyName($companyNameText)
{
    $usernameText = strip_tags($usernameText);
    // do stuff
    return $usernameText;
}

function sanitizeString($stringText)
{
    $stringText = strip_tags($stringText);
    $stringText = str_replace(" ", "", $stringText);
    return $stringText;
}

function sanitizePassword($passwordText)
{
    $passwordText = strip_tags($passwordText);
    return $passwordText;
}


// LOGIN BUTTON PRESSED
if (isset($_POST['loginButton'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $wasSuccesful = $account->login($email, $password);
    if ($wasSuccesful) {
        $_SESSION['studentLoggedIn'] = $email;
        $_SESSION['id'] = getIDFromEmail($con, $email);
        header('Location: ../students/index.php');
    } else {
        echo 'Problem logging in';
    }
}

// REGISTER BUTTON PRESSED
if (isset($_POST['registerButton'])) {
    $firstName = sanitizeString($_POST['registerFirstName']);
    $lastName = sanitizeString($_POST['registerLastName']);
    $email1 = sanitizeString($_POST['registerEmail1']);
    $email2 = sanitizeString($_POST['registerEmail2']);
    $password1 = sanitizePassword($_POST['registerPassword1']);
    $password2 = sanitizePassword($_POST['registerPassword2']);
    $dob = $_POST['dateOfBirth'];

    $wasSuccesful = $account->register($firstName, $lastName, $email1, $email2, $password1, $password2, $dob);
    if ($wasSuccesful) {
        $_SESSION['studentLoggedIn'] = $email1;
        $_SESSION['id'] = getIDFromEmail($con, $email1);
    } else {
        echo 'Problem logging in';
    }
}
