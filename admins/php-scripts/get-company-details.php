<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$companyID = $_POST['companyID'];

$sql = "
SELECT companyID, companyName, companyEmailAddress, companyAbout, companyWorkExperienceDescription, companyWorkExperienceRequirements
FROM companies
WHERE companyID = '$companyID'
";

$result = $con->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $companyEmail = $row['companyEmailAddress'];
  $companyID = $row['companyID'];
  $companyName = $row['companyName'];
  $companyAbout = $row['companyAbout'];
  $workExperienceDescription = $row['companyWorkExperienceDescription'];
  $workExperienceRequirements = $row['companyWorkExperienceRequirements'];

} else {
  echo 'query failure';
}

echo '

<div class="right_header">
  <h1>' . $companyName . '</h1>
</div>

<div class="middle_container">
  <h3>Email address</h3>
  <p>' . $companyEmail . '</p>
  <h3>About the company</h3>
  <p>' . $companyAbout . '</p>';
if ($workExperienceDescription != "") {
  echo '
  <h3>Work experience description</h3>
  <p>' . $workExperienceDescription . '</p>
  <h3>Work experience requirements</h3>
  <p>' . $workExperienceRequirements . '</p>';
};
echo '
</div>';

if ($level == 1) {
  echo '
    <div class="bottom_container">
      <button class="col large_button" type="button" name="button" onclick="editCompany(' . $companyID . ')">Edit company!</button>
    </div>';
} else {
  echo '
    <div class="bottom_container">
      <h1>You cannot edit companies.</h1>
    </div>';
}

?>
