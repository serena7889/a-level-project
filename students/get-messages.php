<?php
require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversation'];
$sql = "
SELECT messageContent, messageSenderID, messageTime, companyName
FROM messages, companies, conversations
WHERE '$uid' = conversationStudentID AND '$conversationID' = conversationID AND conversationID = messageConversationID  AND conversationCompanyID = companyID
ORDER BY messageTime ASC";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($row['messageSenderID'] == $uid) {
        $sender = 'Me';
        $time = $row['messageTime'];
        $time = date("h:ia, d/m/y", strtotime($time));
      } else {
        $sender = $row['companyName'];
      }
      echo '<div><h5>' . $sender . '</h5><h6>' . $time . '</h6><p>' . $row['messageContent'] . '</p></div>';    }
} else {
    echo "0 results";
}
?>
