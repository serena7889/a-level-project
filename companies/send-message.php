<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversation'];
$content = $_POST['content'];
$dateTime = date("Y-m-d H:i:s");

// Insert message
$sql = "
INSERT INTO messages(messageConversationID, messageSenderID, messageContent, messageTime)
VALUES('$conversationID', '$uid', '$content', '$dateTime')
";
if ($con->query($sql)) {
  echo 'message sent';
} else {
  echo 'error sending message';
}

// 2018-12-09 21:04:47
// Update conversation time
$sql = "
UPDATE conversations
SET conversationLatestTime = '$dateTime'
WHERE conversationID = '$conversationID'
";
if ($con->query($sql)) {
  echo 'time update succesful';
} else {
  echo 'time update unsuccesful';
}

?>
