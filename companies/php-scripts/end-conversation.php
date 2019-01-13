<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversationID'];
$dateTime = date("Y-m-d H:i:s");

$endConversation = "
UPDATE conversations
SET conversationActive = '0', conversationLatestTime = '$dateTime'
WHERE conversationID = '$conversationID'
";
$result = $con->query($endConversation);

if ($result) {
  header("Location: ../conversations.php");
};
?>
