<?php

require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversation'];

// echo 'cid: ' . $conversationID . '; uid: ' . $uid;

$sql = "
SELECT companyName,
COALESCE(jobTitle, 'Work Experience') AS conversationTitle
FROM companies, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationCompanyID = companyID and conversationStudentID = '$uid' AND conversationID = '$conversationID'
";

$result = $con->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    echo '
      <h4 class="blue_header">' . $row['conversationTitle'] . ' | ' . $row['companyName'] . '</h4>
      ';

} else {
    echo '
    failure getting header details
    ';
}
?>
