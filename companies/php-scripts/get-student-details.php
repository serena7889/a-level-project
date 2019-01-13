<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversationID'];
$getStudentDetailsQuery = "
SELECT studentFirstName, studentLastName, studentCV
FROM students, conversations
WHERE conversationStudentID = studentID AND conversationID = '$conversationID'
";

$result = $con->query($getStudentDetailsQuery);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $firstName = $row['studentFirstName'];
  $lastName = $row['studentLastName'];
  $studentCV = $row['studentCV'];

} else {
  echo 'query failure';
}

echo '
  <h1>' . $firstName . $lastName . '</h1>
  <br>
  <h3>About the student</h3>
  <p>' . $studentCV . '</p>
';
