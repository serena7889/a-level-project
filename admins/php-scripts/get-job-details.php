<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$jobID = $_POST['jobID'];

$sql = "
SELECT companyID, companyName, jobTitle, jobDescription, jobRequirements, jobTimings, jobWages, jobLocation
FROM jobs, companies
WHERE companyID = jobCompanyID AND jobID = '$jobID'
";

$result = $con->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $companyID = $row['companyID'];
  $companyName = $row['companyName'];
  $jobTitle = $row['jobTitle'];
  $jobDescription = $row['jobDescription'];
  $jobRequirements = $row['jobRequirements'];
  $jobTimings = $row['jobTimings'];
  $jobWages = $row['jobWages'];
  $jobLocation = $row['jobLocation'];

} else {
  echo 'query failure';
}

echo '

<div class="right_header">
  <h1>' . $jobTitle . ' | ' . $companyName . '</h1>
</div>

<div class="middle_container">
  <h3>Description</h3>
  <p>' . $jobDescription . '</p>
  <h3>Requirements</h3>
  <p>' . $jobRequirements . '</p>
  <h3>Timings</h3>
  <p>' . $jobTimings . '</p>
  <h3>Wages</h3>
  <p>' . $jobWages . '</p>
  <h3>Location</h3>
  <p>' . $jobLocation . '</p>
</div>';

if ($level == 1) {
  echo '
    <div class="bottom_container">
      <button class="col large_button" type="button" name="button" onclick="editJob(' . $jobID . ')">Edit job!</button>
    </div>';
} else {
  echo '
    <div class="bottom_container">
      <h1>You cannot edit jobs.</h1>
    </div>';
};
?>
