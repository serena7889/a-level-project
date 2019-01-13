<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversationID'];
$newStatus = $_POST['newStatus'];
$dateTime = date("Y-m-d H:i:s");

// Update status time and time last changed

if ($newStatus == 'accepted' or $newStatus == 'declined') {

  $updateStatusAndTime = "
  UPDATE applications
  SET applicationLatestChangeDate = '$dateTime', applicationStatus = '$newStatus'
  WHERE applicationConversationID = '$conversationID'
  ";

  if ($con->query($updateStatusAndTime)) {

    if ($newStatus == 'declined') {

      $endConversation = "
      UPDATE conversations
      SET conversationActive = 'no'
      WHERE conversationID = '$conversationID'
      ";
      $con->query($endConversation);
    }
  }
};



?>
