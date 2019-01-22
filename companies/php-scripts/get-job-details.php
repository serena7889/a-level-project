<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$jobID = $_POST['jobID'];

$getJobDetailsQuery = "
SELECT companyID, companyName, jobTitle, jobDescription, jobRequirements, jobTimings, jobWages, jobLocation
FROM jobs, companies
WHERE companyID = jobCompanyID AND jobID = '$jobID'
";
$result = $con->query($getJobDetailsQuery);

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

if ($companyID == $uid) {

  echo '
  <div class="bottom_container">
    <button id="edit_job_btn" class="col large_button" type="button" onclick="goToEditJob(' . $jobID . ')">Edit job!</button>
  </div>
  ';

} else {

  echo '
  <div class="bottom_container">
    <h1>Not your job...</h1>
  </div>
  ';

}
?>
