<?php
require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$companyID = $_POST['companyID'];

if (isset($_POST['jobID'])) {
 // is job
 $jobID = $_POST['jobID'];

 $createJobConversationQuery = "
   INSERT INTO conversations(conversationStudentID, conversationCompanyID, conversationJobID)
   VALUES('$uid', '$companyID', '$jobID')
 ";
 $result = $con->query($createJobConversationQuery);

} else {
 // is work experience
 $createWorkExperienceConversationQuery = "
   INSERT INTO conversations(conversationStudentID, conversationCompanyID)
   VALUES('$uid', '$companyID')
 ";
 $result = $con->query($createWorkExperienceConversationQuery);

}


?>
