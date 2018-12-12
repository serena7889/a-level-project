<?php

require '../config.php';
require '../login-checks/student-login-check.php';

if (isset($_POST['sendMessage'])) {
  // $conversationID =
  $message = $_POST['messageContent'];
  $conversationID = $_POST['conversationIDInput'];
  echo "Conversation id: {$conversationID} ...... Message: {$message} ...... Sender id: {$uid}";
  $sql = "INSERT INTO messages(conversationID, senderID, messageContent) VALUES('$conversationID', '$uid', '$message')";
  if (mysqli_query($con, $sql)) {
    header("Location: ../../students/conversations.php?success=true");
  } else {
    header("Location: ../../students/conversations.php?success=false");
  }
}

 ?>
