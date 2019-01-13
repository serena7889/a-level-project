<?php

require '../../includes/config.php';
require '../../includes/login-checks/super-admin-login-check.php';

$adminID = $_POST['adminID'];

$sql = "
SELECT adminID, adminFirstName, adminLastName, adminEmailAddress, adminLevel, adminSignUpDate
FROM admins
WHERE adminID = '$adminID'
";

$result = $con->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $adminFirstName = $row['adminFirstName'];
  $adminLastName = $row['adminLastName'];
  $adminEmail = $row['adminEmailAddress'];
  $adminSUD = $row['adminSignUpDate'];

} else {
  echo 'query failure';
}

echo '
<div class="right_header">
  <h1>' . $adminFirstName . ' ' . $adminLastName . '</h1>
</div>

<div class="middle_container">
  <h3>Email address</h3>
  <p>' . $adminEmail . '</p>
  <h3>Sign up date</h3>
  <p>' . $adminSUD . '</p>
</div>';

echo '
  <div class="bottom_container">
    <button class="col large_button" type="button" name="button" onclick="editAdmin(' . $adminID . ')">Edit admin!</button>
  </div>';

?>
