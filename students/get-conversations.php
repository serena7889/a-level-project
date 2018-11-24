<?php
require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';

$sql = "
SELECT companyName, jobTitle, conversationID, conversationStudentID, conversationCompanyID
FROM jobs, companies, conversations
WHERE jobID = conversationJobID AND companyID = conversationCompanyID AND '" . $uid . "' = conversationStudentID
";
$result = $con->query($sql);
$htmlString = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $htmlString .= '<tr class="clickable-row" data-test="test data" data-convo="' . $row['conversationID'] . '"><td><b>' . $row['jobTitle'] . '</b><br>' . $row['companyName'] . '</td>';
    }
    echo $htmlString;
} else {
    echo "0 results";
}
$con->close();

?>
