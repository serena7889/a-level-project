<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

// $conversationID = $_POST['conversationID'];
// $content = $_POST['content'];
// $dateTime = date("Y-m-d H:i:s");
//
// // Insert message
// $sql = "
// INSERT INTO messages(messageConversationID, messageSenderID, messageContent, messageTime)
// VALUES('$conversationID', '$uid', '$content', '$dateTime')
// ";
// $con->query($sql);
//
// // Update conversation time
// $sql = "
// UPDATE conversations
// SET conversationLatestTime = '$dateTime'
// WHERE conversationID = '$conversationID'
// ";
// $con->query($sql);

$conversationID = $_POST['conversationID'];
$content = $_POST['content'];
$dateTime = date("Y-m-d H:i:s");

// Insert message
$sql = "
INSERT INTO messages(messageConversationID, messageSender, messageContent, messageTime)
VALUES('$conversationID', 'student', '$content', '$dateTime')
";
$con->query($sql);

// Update conversation time
$sql = "
UPDATE conversations
SET conversationLatestTime = '$dateTime'
WHERE conversationID = '$conversationID'
";
$con->query($sql);

?>
