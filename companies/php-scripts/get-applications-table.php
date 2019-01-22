<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$status = $_POST['status'];

$getApplicationDetailsQuery = "
SELECT applicationID, studentFirstName, studentLastName, studentEmailAddress, applicationStatus, applicationDate, applicationLatestChangeDate,
COALESCE(jobTitle, 'Work Experience') AS title
FROM applications, students, conversations
LEFT JOIN jobs ON jobID = conversationJobID
WHERE applicationStatus = '$status' AND applicationConversationID = conversationID AND conversationStudentID = studentID AND conversationCompanyID = '$uid'
ORDER BY applicationLatestChangeDate DESC
";
$result = $con->query($getApplicationDetailsQuery);

if ($status == 'accepted') {

  if ($result->num_rows > 0) {

    // TOP PART OF ACCEPTED TABLE
    echo '
    <table id="applications_table" class="table table-bordered">
      <thead>
        <tr>
          <th>Title</th>
          <th>Student</th>
          <th>Date applied</th>
          <th>Contact details</th>
        </tr>
      </thead>
      <tbody>
    ';

    while ($row = $result->fetch_assoc()) {
      $name = $row['studentFirstName'] . ' ' . $row['studentLastName'];
      $title = $row['title'];
      $dateMade = $row['applicationDate'];
      $studentEmail = $row['studentEmailAddress'];
      // ROWS OF ACCEPTED TABLE
      echo '
        <tr>
          <td>' . $title . '</td>
          <td>' . $name . '</td>
          <td>' . $dateMade . '</td>
          <td>' . $studentEmail . '</td>
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
          <th>Student</th>
          <th>Date applied</th>
        </tr>
      </thead>
      <tbody>
    ';
    while ($row = $result->fetch_assoc()) {
      $name = $row['studentFirstName'] . ' ' . $row['studentLastName'];
      $title = $row['title'];
      $dateMade = $row['applicationDate'];
      // ROWS OF DECLINED TABLE
      echo '
        <tr>
          <td>' . $title . '</td>
          <td>' . $name . '</td>
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
          <th>Student</th>
          <th>Date applied</th>
        </tr>
      </thead>
      <tbody>
    ';
    while ($row = $result->fetch_assoc()) {
      $name = $row['studentFirstName'] . ' ' . $row['studentLastName'];
      $title = $row['title'];
      $dateMade = $row['applicationDate'];
      // ROWS OF UNDECIDED TABLE
      echo '
        <tr>
          <td>' . $title . '</td>
          <td>' . $name . '</td>
          <td>' . $dateMade . '</td>
        </tr>';
    };
    // BOTTOM PART OF UNDECIDED TABLE
    echo '
      </tbody>
    </table>
    ';
  } else {
    echo '<h3>No undeclined applications yet.</h3>';
  }

}

 ?>
