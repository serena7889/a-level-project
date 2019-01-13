<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversationID'];

$checkIfActiveQuery = "
SELECT conversationActive
FROM conversations
WHERE conversationID = '$conversationID'
";

$result = $con->query($checkIfActiveQuery);
$row = $result->fetch_assoc();

// IF CONVERSATION IS ACTIVE, SHOW SEND MESSAGE BOX, OTHERWISE DISPLAY PROMPT
if ($row['conversationActive'] == 'yes') {
  echo '
  <input id="message_content" type="text" maxlength="1000" placeholder="Type a message..." onkeydown="if(event.keyCode==13) sendMessage(' . $conversationID . ');">
  <button id="send_btn" class="send_btn" type="button" onclick="sendMessage(' . $conversationID . ')"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
  ';
} else {
  echo '
    <h1>Conversation has ended</h1>
  ';
}

$con->close();

?>
