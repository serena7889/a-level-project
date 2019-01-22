<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$getConversationsListQuery = "
SELECT companyName, conversationID, conversationStudentID, conversationCompanyID, conversationLatestTime,
COALESCE(jobTitle, 'Work Experience') AS conversationTitle
FROM companies, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationCompanyID = companyID and conversationStudentID = '$uid'
ORDER BY conversationLatestTime DESC
";
$result = $con->query($getConversationsListQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $time = $row['conversationLatestTime'];
      $time = date("d M y", strtotime($time));
      echo '
      <div class="list_item_container" data-convo="' . $row['conversationID'] . '">
        <div class="list_item">
          <h5>' . $row['conversationTitle'] . '<span class="chat_date">' . $time . '</span></h5>
          <p>' . $row['companyName'] . '</p>
        </div>
      </div>';
    }

} else {
    echo "0 results";
}
$con->close();

?>
