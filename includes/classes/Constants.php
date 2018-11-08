<?php

class Constants {

  // Registration errors
  public static $pwDoNotMatch = "Your passwords must match.";
  public static $pwNotAlphaNum = "Your password can only contain letters and numbers.";
  public static $pwWrongLength = "Your password must be between 6 and 20 characters.";
  public static $emInvalid = "Your email is invalid.";
  public static $emDoNotMatch = "Your emails must match.";
  public static $emTaken = "This email address has already been used.";
  public static $fnWrongLength = "Your first name must be between 2 and 25 characters.";
  public static $lnWrongLength = "Your last name must be between 2 and 25 characters.";
  public static $dobInvalid = "This is not a valid date of birth.";

  // Login errors
  public static $loginFailure = "Your email or password is incorrect.";

}

?>
