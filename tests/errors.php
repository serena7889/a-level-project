<?php
require '../includes/config..php';
// include '../includes/constants.php';

$loginFailure = "Your email or password is incorrect.";

$errorArray = array();

function validateLoginDetails($con, $errorArray, $email, $password) {
    $loginStudentQuery = "SELECT * FROM students WHERE studentEmailAddress = '$email' and studentPassword = '$password'";
    $query = $con->query($loginStudentQuery);
    if ($query->num_rows != 1) {
      array_push($errorArray, $loginFailure);
    }
    return $errorArray;
}

function getError($errorArray, $error) {
    // $error = "123";
    if (!in_array($error, $errorArray)) {
        $error = "";
    }
    return "<span class='errorMessage'>" . $error . "</span>";
    // return "<span class='errorMessage'>" . "123" . "</span>";
}

if (isset($_POST['loginButton'])) {
    $email = sanitizeString($_POST['loginEmail']);
    $password = sanitizePassword($_POST['loginPassword']);
    $encryptedPassword = md5($password);
    $errorArray = validateLoginDetails($con, $errorArray, $email, $encryptedPassword);

    if (empty($errorArray)) {
      $_SESSION['studentLoggedIn'] = $email;
      $_SESSION['id'] = getIDFromEmail($con, $email);
      header('Location: index.php');
    }
}

 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Errors</title>
  </head>
  <body>
    <form class="" action="errors.php" method="post">

      <p>
        <?php echo getError($errorArray, $loginFailure); ?>
        <label for="loginEmail">Email: </label>
        <input id="loginEmail" type="text" name="loginEmail" placeholder="e.g. flash@starlabs.com" value="<?php getValue('loginEmail'); ?>" required>
      </p>

      <p>
        <label for="loginPassword">Password: </label>
        <input id="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
      </p>

      <button type="submit" name="loginButton">LOG IN!</button>

  </form>

  </body>
</html>
