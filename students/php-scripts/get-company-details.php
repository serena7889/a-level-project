<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversationID'];
$getStudentDetailsQuery = "
SELECT companyName, companyAbout
FROM companies, conversations
WHERE conversationCompanyID = companyID AND conversationID = '$conversationID'
";

$result = $con->query($getStudentDetailsQuery);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $name = $row['companyName'];
  $about = $row['companyAbout'];

} else {
  echo 'query failure';
}

echo '
  <h1>' . $name . '</h1>
  <br>
  <h3>About ' . $name . '</h3>
  <p>' . $about . '</p>
';
