<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$status = $_POST['status'];

$getApplicationDetailsQuery = "
SELECT applicationID, conversationStudentID, studentFirstName, studentLastName, companyName, companyEmailAddress, applicationStatus, applicationDate, applicationLatestChangeDate,
COALESCE(jobTitle, 'Work Experience') AS title
FROM applications, companies, students, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE applicationStatus = '$status' AND applicationConversationID = conversationID AND conversationCompanyID = companyID  AND conversationStudentID = studentID
ORDER BY applicationLatestChangeDate DESC";
$result = $con->query($getApplicationDetailsQuery);
if ($result->num_rows > 0) {
  echo '
  <table id="applications_table" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Student</th>
        <th>Company</th>
        <th>Date made</th>
      </tr>
    </thead>
    <tbody>';
  while ($row = $result->fetch_assoc()) {
    $applicationID = $row['applicationID'];
    $companyName = $row['companyName'];
    $studentName = $row['studentFirstName'] . ' ' . $row['studentLastName'];
    $title = $row['title'];
    $dateMade = $row['applicationDate'];
    echo '
      <tr>
        <td>' . $applicationID . '</td>
        <td>' . $title . '</td>
        <td>' . $studentName . '</td>
        <td>' . $companyName . '</td>
        <td>' . $dateMade . '</td>
      </tr>';
  }
  echo '</tbody> </table>';
} else {
  // no applications
  if ($status == 'accepted') {
    echo '<h3>No accepted applications yet.</h3>';
  } else if ($status == 'declined') {
    echo '<h3>No declined applications yet.</h3>';
  } else if ($status == 'undecided') {
    echo '<h3>No undeclined applications yet.</h3>';
  }
}
?>
