<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$status = $_POST['status'];

$sql = "
SELECT applicationID, conversationStudentID, companyName, companyEmailAddress, applicationStatus, applicationDate, applicationLatestChangeDate,
COALESCE(jobTitle, 'Work Experience') AS title
FROM applications, companies, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE applicationStatus = '$status' AND applicationConversationID = conversationID AND conversationCompanyID = companyID  AND conversationStudentID = '$uid'
ORDER BY applicationLatestChangeDate DESC
";
$result = $con->query($sql);

if ($status == 'accepted') {

  if ($result->num_rows > 0) {

    // TOP PART OF ACCEPTED TABLE
    echo '
    <table id="applications_table" class="table table-bordered">
      <thead>
        <tr>
          <th>Title</th>
          <th>Company</th>
          <th>Date applied</th>
          <th>Contact details</th>
        </tr>
      </thead>
      <tbody>
    ';

    while ($row = $result->fetch_assoc()) {
      $companyName = $row['companyName'];
      $title = $row['title'];
      $dateMade = $row['applicationDate'];
      $companyEmail = $row['companyEmailAddress'];
      // ROWS OF ACCEPTED TABLE
      echo '
        <tr>
          <td>' . $title . '</td>
          <td>' . $companyName . '</td>
          <td>' . $dateMade . '</td>
          <td>' . $companyEmail . '</td>
        </tr>';
    };
    // BOTTOM PART OF ACCEPTED TABLE
    echo '
      </tbody>
    </table>
    ';
  } else {
    echo '<h3>No accepted applications yet.</h3>';
  }

} else if ($status == 'declined') {

  if ($result->num_rows > 0) {
    // TOP PART OF DECLINED TABLE
    echo '
    <table id="applications_table" class="table table-bordered">
      <thead>
        <tr>
          <th>Title</th>
          <th>Company</th>
          <th>Date applied</th>
        </tr>
      </thead>
      <tbody>
    ';
    while ($row = $result->fetch_assoc()) {
      $companyName = $row['companyName'];
      $title = $row['title'];
      $dateMade = $row['applicationDate'];
      // ROWS OF DECLINED TABLE
      echo '
        <tr>
          <td>' . $title . '</td>
          <td>' . $companyName . '</td>
          <td>' . $dateMade . '</td>
        </tr>';
    };
    // BOTTOM PART OF DECLINED TABLE
    echo '
      </tbody>
    </table>
    ';
  } else {
    echo '<h3>No declined applications yet.</h3>';
  }


} else if ($status == 'undecided') {

  if ($result->num_rows > 0) {
    echo '
    <table id="applications_table" class="table table-bordered">
      <thead>
        <tr>
          <th>Title</th>
          <th>Company</th>
          <th>Date applied</th>
        </tr>
      </thead>
      <tbody>
    ';
    while ($row = $result->fetch_assoc()) {
      $companyName = $row['companyName'];
      $title = $row['title'];
      $dateMade = $row['applicationDate'];
      // ROWS OF UNDECIDED TABLE
      echo '
        <tr>
          <td>' . $title . '</td>
          <td>' . $companyName . '</td>
          <td>' . $dateMade . '</td>
        </tr>';
    };
    // BOTTOM PART OF UNDECIDED TABLE
    echo '
      </tbody>
    </table>
    ';
  } else {
    echo '<h3>No undecided applications yet.</h3>';
  }

}








 ?>
