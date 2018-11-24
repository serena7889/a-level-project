<?php
require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

$sql = "
SELECT studentFirstName, studentLastName, jobTitle, conversationID, conversationStudentID, conversationCompanyID
FROM jobs, students, conversations
WHERE jobID = conversationJobID AND studentID = conversationStudentID AND '" . $uid . "' = conversationCompanyID
";
$result = $con->query($sql);
$htmlString = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $htmlString .= '<tr class="clickable-row" data-convo="' . $row['conversationID'] . '"><td><b>' . $row['jobTitle'] . '</b><br>' . $row['studentFirstName'] . " " . $row['studentLastName']; . '</td>';
    }
    echo $htmlString;
} else {
    echo "0 results";
}
$con->close();

?>
