<?php

require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/admin-handler.php';

?>

<html>
<head>
	<title>EDIT ADMIN</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<?php

include '../includes/headers/admin-header.php';

$adminID = $_GET['adminID'];

$sql = "
SELECT adminFirstName, adminLastName, adminEmailAddress, adminLevel, adminSignUpDate
FROM admins
WHERE adminID = '$adminID'
";

$result = $con->query($sql);
if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $firstName = $row['adminFirstName'];
  $lastName = $row['adminLastName'];
  $email = $row['adminEmailAddress'];
  $level = $row['adminLevel'];
  $signUpDate = $row['adminSignUpDate'];
} else {
  echo 'query error';
}
?>

  <form id="registerForm" action="edit-admin.php" method="POST">
    <h2>Edit admin user...</h2>
    <div class="row">
      <div class="col">
        <?php echo getError($errorArray, $fnWrongLength); ?>
        <label for="registerFirstName">First name: </label>
        <input id="registerFirstName" type="text" name="registerFirstName" placeholder="e.g. Bart" value="<?php echo $firstName; ?>" required>
      </div>
      <div class="col">
        <?php echo getError($errorArray, $lnWrongLength); ?>
        <label for="registerLastName">Last name: </label>
        <input id="registerLastName" type="text" name="registerLastName" placeholder="e.g. Simpson" value="<?php echo $lastName; ?>" required>
      </div>
    </div>
    <div>
      <?php echo getError($errorArray, $emTaken); ?>
      <?php echo getError($errorArray, $emInvalid); ?>
      <label for="registerEmail1">Email: </label>
      <input id="registerEmail1" type="email" name="registerEmail1" placeholder="e.g. bart@springfield.com" value="<?php echo $email; ?>" required>
    </div>
    <div>
      <?php echo getError($errorArray, $emDoNotMatch); ?>
      <label for="registerEmail2">Confirm email: </label>
      <input id="registerEmail2" type="email" name="registerEmail2" placeholder="e.g. bart@springfield.com" required>
    </div>
    <button type="submit" name="addAdminButton">SIGN UP!</button>
  </form>



  <br>


  <form class="" action="edit-admin.php" method="post">
    <p>
      <label for="oldPassword">Enter your current password: </label>
      <input type="password" name="oldPassword">
    </p>
    <p>
      <label for="newPassword1">Enter your new password: </label>
      <input type="password" name="newPassword1">
    </p>
    <p>
      <label for="newPassword2">Confirm your password: </label>
      <input type="password" name="newPassword2">
    </p>
    <input type="submit" name="updatePassword" value="Change password">
  </form>
</body>
</html>
