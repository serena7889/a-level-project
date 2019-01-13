<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversationID'];
$date = date("Y-m-d");
$dateTime = date("Y-m-d H:i:s");

$sql = "
INSERT INTO applications(applicationConversationID, applicationDate, applicationLatestChangeDate)
VALUES ('$conversationID', '$date', '$dateTime')
";

$result = $con->query($sql);

if ($result) {
  header("Location: ../applications.php");
}
?>
