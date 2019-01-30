<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$studentID = $_POST['studentID'];

$getStudentDetailsQuery = "
SELECT studentID, studentFirstName, studentLastName, studentEmailAddress, studentDateOfBirth, studentCV
FROM students
WHERE studentID = '$studentID'
";

$result = $con->query($getStudentDetailsQuery);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $studentFirstName = $row['studentFirstName'];
  $studentLastName = $row['studentLastName'];
  $studentEmail = $row['studentEmailAddress'];
  $studentDOB = $row['studentDateOfBirth'];
  $studentCV = $row['studentCV'];

}

echo '
<div class="right_header">
  <h1>' . $studentFirstName . ' ' . $studentLastName . '</h1>
</div>

<div class="middle_container">
  <h3>Email address</h3>
  <p>' . $studentEmail . '</p>
  <h3>Date of birth</h3>
  <p>' . $studentDOB . '</p>
  <h3>CV</h3>
  <p>' . $studentCV . '</p>
</div>';

if ($level == 1) {
  echo '
    <div class="bottom_container">
      <button class="col large_button" type="button" name="button" onclick="editStudent(' . $studentID . ')">Edit student!</button>
    </div>';
} else {
  echo '
    <div class="bottom_container">
      <h1>You cannot edit students.</h1>
    </div>';
}

?>
