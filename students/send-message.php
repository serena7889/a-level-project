<?php

require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';
$conversationID = $_POST['conversation'];
$content = $_POST['content'];
$sql = "
INSERT INTO messages(messageConversationID, messageSenderID, messageContent)
VALUES('$conversationID', '$uid', '$content')
";
$result = $con->query($sql);
if ($result) {
  echo 'message sent';
} else {
  echo 'error sending message';
}
?>
