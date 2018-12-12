<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversation'];
$sql = "
SELECT messageContent, messageSenderID, messageTime, studentFirstName, studentLastName
FROM messages, students, conversations
WHERE '$uid' = conversationCompanyID AND '$conversationID' = conversationID AND conversationID = messageConversationID  AND conversationStudentID = studentID
ORDER BY messageTime ASC";

$result = $con->query($sql);

//
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //

      if ($row['messageSenderID'] == $uid) {
        // message from student
        $time = $row['messageTime'];
        $time = date("h:ia    |    d/m/y", strtotime($time));
        $content = $row['messageContent'];

        echo '
        <div class="sent_message_container">
          <div class="sent_message">
            <p>' . $content . '</p>
            <span class="time_date">' . $time . '</span>
          </div>
        </div>';

      } else {
        // message from company
        echo '
        <div class="received_message_container">
          <div class="received_message">
            <p>' . $row['messageContent'] . '</p>
            <span class="time_date">' . $time . '</span>
          </div>
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
