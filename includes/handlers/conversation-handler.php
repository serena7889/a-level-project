<?php
require '../config.php';
require '../login-checks/student-login-check.php';

if (isset($_POST['interestedInput'])){

  $studentID = $uid;
  $companyID = $_GET['companyID'];

 if ($_GET['isJob'] == 'true') {
   // is job
   echo
   $jobID = $_GET['jobID'];
   $sql = "INSERT INTO conversations(conversationStudentID, conversationCompanyID, conversationJobID)
           VALUES('$uid', '$companyID', '$jobID')";
   if ($con->query($sql)) {
     header('Location: ../../students/conversations.php');
   } else {
     echo 'insert unsuccesful';
   }


 } else {
   // is work experience
   $sql = "INSERT INTO conversations(conversationStudentID, conversationCompanyID)
           VALUES('$uid', '$companyID')";
   if (mysqli_query($con, $sql)) {
     header('Location: ../../students/conversations.php');
   } else {
     echo 'experience insert unsuccesful';
   }
 }
}

?>
