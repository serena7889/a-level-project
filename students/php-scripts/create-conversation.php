<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$companyID = $_POST['companyID'];
$dateTime = date("Y-m-d H:i:s");

if (isset($_POST['jobID'])) {
 // is job
 $jobID = $_POST['jobID'];

 $createJobConversationQuery = "
   INSERT INTO conversations(conversationStudentID, conversationCompanyID, conversationJobID, conversationLatestTime)
   VALUES('$uid', '$companyID', '$jobID', '$dateTime')
 ";
 $result = $con->query($createJobConversationQuery);

} else {
 // is work experience
 $createWorkExperienceConversationQuery = "
   INSERT INTO conversations(conversationStudentID, conversationCompanyID, conversationLatestTime)
   VALUES('$uid', '$companyID', '$dateTime')
 ";
 $result = $con->query($createWorkExperienceConversationQuery);

}

?>
