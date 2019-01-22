<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$jobID = $_POST['jobID'];

$jobDetailsQuery = "
SELECT companyID, companyName, jobTitle, jobDescription, jobRequirements, jobTimings, jobWages, jobLocation
FROM jobs, companies
WHERE companyID = jobCompanyID AND jobID = '$jobID'
";

$result = $con->query($jobDetailsQuery);

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
  </div>
  ';
}

$alreadyConversationQuery = "
  SELECT conversationID
  FROM conversations, students
  WHERE conversationJobID = '$jobID' AND conversationStudentID = '$uid' and conversationActive = 'yes'
";

$result = $con->query($alreadyConversationQuery);

if ($result->num_rows == 0) {
  // No conversation yet
  echo '
  <div class="bottom_container">
    <button class="col large_button" type="button" name="button" onclick="createConversation(' . $jobID . ', ' . $companyID . ')">I\'m Interested!</button>
  </div>';
} else {
  //  Already a conversation
  echo '
  <div class="bottom_container">
    <h1>Already started conversation</h1>
  </div>';
}

?>
