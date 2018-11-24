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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($row['messageSenderID'] == $uid) {
        $sender = 'Me';
        $time = $row['messageTime'];
        $time = date("h:ia, d/m/y", strtotime($time));
      } else {
        $sender = $row['studentFirstName'] . " " . $row['studentLastName'];
      }
      echo '<div><h5>' . $sender . '</h5><h6>' . $time . '</h6><p>' . $row['messageContent'] . '</p></div>';
    }
} else {
    echo "0 results";
}
?>
