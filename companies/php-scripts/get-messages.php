<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversationID'];
$sql = "
SELECT messageContent, messageSender, messageTime, studentFirstName, studentLastName
FROM messages, students, conversations
WHERE '$uid' = conversationCompanyID AND '$conversationID' = conversationID AND conversationID = messageConversationID  AND conversationStudentID = studentID
ORDER BY messageTime ASC";

$result = $con->query($sql);

//
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //

      $time = $row['messageTime'];
      $time = date("h:ia | d/m/y", strtotime($time));
      $content = $row['messageContent'];

      if ($row['messageSender'] == 'company') {
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
          <p>' . $row['messageContent'] . '</p>
          <span class="time_date">' . $time . '</span>
        </div>';
      }
    }

} else {
    echo '
    <div class="no_messages_prompt">
      <h4>No messages yet...</h4>
    </div>
    ';
}
?>
