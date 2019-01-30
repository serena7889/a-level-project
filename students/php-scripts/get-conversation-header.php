<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$conversationID = $_POST['conversationID'];

$headerDetailsQuery = "
SELECT companyName,
COALESCE(jobTitle, 'Work Experience') AS conversationTitle
FROM companies, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationCompanyID = companyID and conversationStudentID = '$uid' AND conversationID = '$conversationID' AND conversationActive = 'yes'";
$result = $con->query($headerDetailsQuery);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $title = $row['conversationTitle'];
    $companyName = $row['companyName'];

    echo '
    <div class="header_text">
      <h1 id="title" onclick="showOpportunityDetails(' . $conversationID . ')">' . $title . ' </h1>
      <h1> | </h1>
      <h1 id="company_name" onclick="showCompanyDetails(' . $conversationID . ')">' . $companyName . '</h1>
    </div>';

    // ONLY SHOW 'APPLY BUTTON' IF THE STUDENT HAS NOT ALREADY APPLIED
    $checkNotAppliedQuery = "
    SELECT applicationID
    FROM applications
    WHERE applicationConversationID = '$conversationID'";
    $result = $con->query($checkNotAppliedQuery);
    if ($result->num_rows == 0) {
      echo '
      <div class="header_buttons">
        <button id="apply_btn" type="button" name="apply_btn" onclick="apply(' . $conversationID . ')">APPLY</button>
      <div>';
    }

    // ONLY SHOW 'END BUTTON' IF THE CONVERSATION IS ACTIVE
    $checkNotEnded = "
    SELECT conversationID
    FROM conversations
    WHERE conversationID = '$conversationID' AND conversationActive = 'yes'
    ";
    $result = $con->query($checkNotEnded);
    if ($result->num_rows > 0) {
      echo '
      <div class="header_buttons">
        <button id="end_btn" type="button" name="end_btn" onclick="end(' . $conversationID . ')">END</button>
      </div>';
    }
}

?>
