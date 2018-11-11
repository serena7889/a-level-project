<?php

class Account
{
    private $con;
    private $errorArray;

    public function __construct($con)
    {
        $this->con = $con;
        $this->errorArray = array();
    }

    public function register($fn, $ln, $em1, $em2, $pw1, $pw2, $dob)
    {
        // echo 'register validate';
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em1, $em2);
        $this->validatePasswords($pw1, $pw2);
        $this->validateDateOfBirth($dob);

        // echo 'register errors';
        if (empty($this->errorArray)) {
            // insert into db
            return $this->insertUserDetails($fn, $ln, $em1, $pw1, $dob);
        } else {
            // display error
            return false;
        }
    }

    private function insertUserDetails($fn, $ln, $em, $pw, $dob)
    {
        // echo 'insert';
        $encryptedPw = md5($pw);
        $signUpDate = date("Y-m-d");
        $sql = "INSERT INTO students(studentFirstName, studentLastName, studentEmailAddress, studentPassword, studentDateOfBirth, studentSignUpDate) VALUES('$fn', '$ln', '$em', '$encryptedPw', '$dob', '$signUpDate')";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function login($em, $pw)
    {
        $pw = md5($pw);

        $sql = "SELECT * FROM students WHERE studentEmailAddress = '$em' and studentPassword = '$pw'";
        $query = mysqli_query($this->con, $sql);
        if ($query->num_rows == 1) {
            return true;
        } else {
            array_push($this->errorArray, Constants::$loginFailure);
            return false;
        }
    }

    public function getError($error)
    {
        // echo 'error';
        if (!in_array($error, $this->errorArray)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    // VALIDATION FUNCTIONS
    private function validateFirstName($firstName)
    {
        if (strlen($firstName) > 25 || strlen($firstName) < 2) {
            array_push($this->errorArray, Constants::$fnWrongLength);
            return;
        }
    }

    private function validateLastName($lastName)
    {
        if (strlen($lastName) > 25 || strlen($lastName) < 2) {
            array_push($this->errorArray, Constants::$lnWrongLength);
            return;
        }
    }

    private function validateEmails($email1, $email2)
    {
        if ($email1 != $email2) {
            array_push($this->errorArray, Constants::$emDoNotMatch);
            return;
        }
        $sql = "SELECT studentEmail FROM students WHERE studentEmail = '$email1'";
        $checkUniqueQuery = mysqli_query($this->con, $sql);
        if ($checkUniqueQuery->num_rows > 0) {
            array_push($this->errorArray, Constants::$emTaken);
            return;
        }
        if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emInvalid);
            return;
        }
    }

    private function validatePasswords($password1, $password2)
    {
        if ($password1 != $password2) {
            array_push($this->errorArray, Constants::$pwDoNotMatch);
            return;
        }
        if (strlen($password1) > 20 || strlen($password1) < 6) {
            array_push($this->errorArray, Constants::$pwWrongLength);
            return;
        }
    }

    private function validateDateOfBirth($dob)
    {
        $ymd = explode('-', $dob);
        if ((!(checkdate($ymd[0], $ymd[1], $ymd[2]))) || $dob > time()) {
            array_push($this->errorArray, Constants::$dobInvalid);
        }
        return;
    }
}
