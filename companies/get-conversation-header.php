<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversation'];

// echo 'cid: ' . $conversationID . '; uid: ' . $uid;

$sql = "
SELECT studentFirstName, studentLastName,
COALESCE(jobTitle, 'Work Experience') AS conversationTitle
FROM students, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationStudentID = studentID and conversationCompanyID = '$uid' AND conversationID = '$conversationID'
";

$result = $con->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    echo '
      <h4 class="blue_header">' . $row['conversationTitle'] . ' | ' . $row['studentFirstName'] . ' ' . $row['studentLastName'] . '</h4>
      ';

} else {
    echo '
    failure getting header details
    ';
}
?>
