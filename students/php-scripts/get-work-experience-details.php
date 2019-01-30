<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$companyID = $_POST['companyID'];

$getCompanyDetailsQuery = "
SELECT companyID, companyName, companyAbout, companyWorkExperienceDescription, companyWorkExperienceRequirements
FROM companies
WHERE companyID = '$companyID'";
$result = $con->query($getCompanyDetailsQuery);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $companyID = $row['companyID'];
  $companyName = $row['companyName'];
  $companyAbout = $row['companyAbout'];
  $workExperienceDescription = $row['companyWorkExperienceDescription'];
  $workExperienceRequirements = $row['companyWorkExperienceRequirements'];
}

echo '
<div class="right_header">
  <h1>Work Experience | ' . $companyName . '</h1>
</div>
<div class="middle_container">
  <h3>About the company</h3>
  <p>' . $companyAbout . '</p>
  <h3>Description</h3>
  <p>' . $workExperienceDescription . '</p>
  <h3>Requirements</h3>
  <p>' . $workExperienceRequirements . '</p>
</div>';

$alreadyConversationQuery = "
  SELECT conversationID
  FROM conversations
  WHERE conversationCompanyID = '$companyID' AND conversationStudentID = '$uid' AND conversationJobID IS NULL AND conversationActive = 'yes'";
$result = $con->query($alreadyConversationQuery);

if ($result->num_rows == 0) {
  // No conversation yet
  echo'
  <div class="bottom_container">
    <button class="col large_button" type="button" name="button" onclick="createConversation(' . $companyID . ')">I\'m Interested!</button>
  </div>';
} else {
  //  Already a conversation
  echo '
  <div class="bottom_container">
    <h1>Already started conversation</h1>
  </div>';
}
?>
