<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversationID'];

$checkIfJobQuery = "
SELECT conversationJobID, conversationCompanyID
FROM conversations
WHERE conversationID = '$conversationID'
";

$result = $con->query($checkIfJobQuery);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $jobID = $row['conversationJobID'];

  if (is_null($jobID)) {
    // is work experience
    $companyID = $row['conversationCompanyID'];

    $getWorkExperienceDetailsQuery = "
    SELECT companyName, companyAbout, companyWorkExperienceDescription, companyWorkExperienceRequirements
    FROM companies
    WHERE companyID = '$companyID'
    ";

    $result = $con->query($getWorkExperienceDetailsQuery);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      $companyName = $row['companyName'];
      $companyAbout = $row['companyAbout'];
      $workExperienceDescription = $row['companyWorkExperienceDescription'];
      $workExperienceRequirements = $row['companyWorkExperienceRequirements'];

    } else {
      echo 'query failure';
    }

    echo '
      <h1>Work Experience with ' . $companyName . '</h1>
      <br>
      <h3>About ' . $companyName . '</h3>
      <p>' . $companyAbout . '</p>
      <h3>Description</h3>
      <p>' . $workExperienceDescription . '</p>
      <h3>Requirements</h3>
      <p>' . $workExperienceRequirements . '</p>
    ';



  } else {
    // is a job
    $getJobDetails = "
    SELECT companyID, companyName, jobTitle, jobDescription, jobRequirements, jobTimings, jobWages, jobLocation
    FROM jobs, companies
    WHERE companyID = jobCompanyID AND jobID = '$jobID'
    ";
    $result = $con->query($getJobDetails);
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
      <h1>' . $companyName . '</h1>
      <br>
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
    ';
  }

}
