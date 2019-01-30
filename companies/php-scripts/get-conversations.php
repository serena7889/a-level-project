<?php
require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$getConversationsQuery = "
SELECT studentFirstName, studentLastName, conversationID, conversationStudentID, conversationCompanyID, conversationLatestTime,
COALESCE(jobTitle, 'Work Experience') AS conversationTitle
FROM students, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationStudentID = studentID and conversationCompanyID = '$uid'
ORDER BY conversationLatestTime DESC
";
$result = $con->query($getConversationsQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $time = $row['conversationLatestTime'];
      $time = date("d M y", strtotime($time));
      echo '
      <div class="list_item_container" data-convo="' . $row['conversationID'] . '">
        <div class="list_item">
          <h5>' . $row['studentFirstName'] . ' ' . $row['studentLastName'] . '<span class="chat_date">' . $time . '</span></h5>
          <p>' . $row['conversationTitle'] . '</p>
        </div>
      </div>';
    }
}
$con->close();

?>
