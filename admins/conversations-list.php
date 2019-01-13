<?php

require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">

    $(document).ready(function() {

      // FILTERS DIVS IN LIST BY SEARCH BAR INPUT
      $("#search_bar").on("keyup click input", function () {
        var searchText = $(this).val().toLowerCase();
        if (searchText.length) {
            $(".list_item_container").hide().filter(function () {
              var itemText = $('h5, p',this).text().toLowerCase();
                return itemText.indexOf(searchText) != -1;
            }).show();
        } else {
            $(".list_item_container").show();
        };
      });

    });


    </script>
    <title>APPLICATIONS</title>
  </head>
  <body>
    <?php
    include '../includes/headers/admin-header.php';
     ?>
    <h1>Applications</h1>
    <div class="search_bar_container">
      <input id="search_bar" type="text" class="search_bar" placeholder="Search">
    </div>
    <?php
    echo '
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Conversation ID</th>
          <th>Opportunity Title</th>
          <th>Company</th>
          <th>Student</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
    ';

    $conversationDetailsQuery = "
    SELECT conversationID, companyName, studentFirstName, studentLastName, conversationActive,
    COALESCE(jobTitle, 'Work Experience') AS title
    FROM companies, students, conversations
    LEFT JOIN jobs ON jobID = conversationJobID
    WHERE conversationJobID = jobID AND conversationCompanyID = companyID AND conversationStudentID = studentID
    ORDER BY conversationLatestTime DESC
    ";

    $result = $con->query($conversationDetailsQuery);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $conversationID = $row['conversationID'];
        $companyName = $row['companyName'];
        $studentName = $row['studentFirstName'] . ' ' . $row['studentLastName'];
        $title = $row['title'];
        $conversationActive = ($row['conversationActive'] == 'yes' ? 'active' : 'ended');

        echo '
          <tr>
            <td>' . $conversationID . '</td>
            <td>' . $title . '</td>
            <td>' . $companyName . '</td>
            <td>' . $studentName . '</td>
            <td>' . $conversationActive . '</td>';

        echo '</tr>';
      };

    } else {
      echo 'query failure';
    }

    echo '
      </tbody>
    </table>
    ';
     ?>
  </body>
</html>
