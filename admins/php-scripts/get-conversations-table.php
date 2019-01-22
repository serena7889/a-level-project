<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$status = $_POST['status'];
$active = ($status == 'active' ? 'yes' : 'no');

$getConversationDetailsQuery = "
SELECT conversationID, studentFirstName, studentLastName, companyName, conversationLatestTime, conversationActive, COUNT(conversationID) AS numMessages,
COALESCE(jobTitle, 'Work Experience') AS title
FROM students, companies, messages, conversations LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationActive = '$active' AND conversationCompanyID = companyID AND conversationStudentID = studentID AND messageConversationID = conversationID
GROUP BY conversationID
ORDER BY conversationLatestTime DESC
";
$result = $con->query($getConversationDetailsQuery);


if ($result->num_rows > 0) {

  // TOP PART OF ACCEPTED TABLE
  echo '
  <table id="applications_table" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Opportunity</th>
        <th>Student</th>
        <th>Company</th>
        <th>Messages</th>
        <th>Latest Change</th>
      </tr>
    </thead>
    <tbody>
  ';

  while ($row = $result->fetch_assoc()) {
    echo '
      <tr>
        <td>' . $row['conversationID'] . '</td>
        <td>' . $row['title']. '</td>
        <td>' . $row['studentFirstName'] . ' ' . $row['studentLastName'] . '</td>
        <td>' . $row['companyName'] . '</td>
        <td>' . $row['numMessages'] . '</td>
        <td>' . $row['conversationLatestTime'] . '</td>
      </tr>';
  };
  echo '
    </tbody>
  </table>
  ';
} else {
  echo '<h3>No ' . $status . ' conversations yet.</h3>';
}



 ?>
