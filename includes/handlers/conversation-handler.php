<?php
require '../config.php';
require '../login-checks/student-login-check.php';

if (isset($_POST['interestedInput'])){
  // is a job
  $studentID = $uid;

 if ($_GET['isJob'] == 'true') {
   $jobID = $_GET['jobID'];
   $companyID = $_GET['companyID'];

   $sql = "INSERT INTO conversations(conversationStudentID, conversationCompanyID, conversationJobID)
   VALUES('$uid', '$companyID', '$jobID')";
   if (mysqli_query($con, $sql)) {
     header('Location: ../../students/conversations.php');
   } else {
     echo 'insert unsuccesful';
   }

 } else {
   // is work experience
    $companyID = $_GET['companyID'];
 }
}
?>
