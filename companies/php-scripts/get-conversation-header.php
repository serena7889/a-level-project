<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$conversationID = $_POST['conversationID'];

$headerDetailsQuery = "
SELECT studentFirstName, studentLastName,
COALESCE(jobTitle, 'Work Experience') AS conversationTitle
FROM students, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE conversationStudentID = studentID and conversationCompanyID = '$uid' AND conversationID = '$conversationID'";

$result = $con->query($headerDetailsQuery);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $title = $row['conversationTitle'];
    $firstName = $row['studentFirstName'];
    $lastName = $row['studentLastName'];
    echo '
    <div class="header_text">
      <h1 id="title" class="header_text" onclick="showOpportunityDetails(' . $conversationID . ')">' . $title . '</h1>
      <h1 class="header_text"> | </h1>
      <h1 id="student_name" class="header_text" onclick="showStudentDetails(' . $conversationID . ')"> ' . $firstName . ' ' . $lastName . '</h1>
    </div>
    ';

    $undecidedApplicationQuery = "
    SELECT applicationID
    FROM applications
    WHERE applicationStatus = 'undecided' AND applicationConversationID = '$conversationID'";

    $result = $con->query($undecidedApplicationQuery);
    if ($result->num_rows == 1) {
      echo '
      <div class="header_buttons">
        <button id="accept_btn" class="header_button" type="button" name="accept_btn" onclick="changeStatus(' . $conversationID . ', \'accepted\')">ACCEPT</button>
        <button id="decline_btn" class="header_button" type="button" name="decline_btn" onclick="changeStatus(' . $conversationID . ', \'declined\')">DECLINE</button>
      </div>
      ';
    } else {
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
        </div>
        ';
      }

    }
}
?>
