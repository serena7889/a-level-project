<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversationID'];

$getMessageQuery = "
SELECT messageContent, messageSender, messageTime, companyName
FROM messages, companies, conversations
WHERE '$uid' = conversationStudentID AND '$conversationID' = conversationID AND conversationID = messageConversationID  AND conversationCompanyID = companyID
ORDER BY messageTime ASC";

$result = $con->query($getMessageQuery);

//
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //

      $time = $row['messageTime'];
      $time = date("h:ia    |    d/m/y", strtotime($time));
      $content = $row['messageContent'];

      if ($row['messageSender'] == 'student') {
        // message from student

        echo '
        <div class="sent_message message">
          <p>' . $content . '</p>
          <span class="time_date">' . $time . '</span>
        </div>';

      } else {
        // message from company
        echo '
        <div class="received_message message">
          <p>' . $content . '</p>
          <span class="time_date">' . $time . '</span>
        </div>';
      }
    }

};

?>
