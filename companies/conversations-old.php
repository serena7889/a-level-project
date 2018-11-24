<?php
require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CONVERSATIONS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" href="../includes/css/list-and-details.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  </head>
  <body>

    <?php include '../includes/headers/company-header.php'; ?>

    <div class="container">

      <!-- TOP CONTENT -->
      <div class="topContent">

      </div>

      <!-- MAIN CONTENT -->
      <div class="mainContent row">

        <!-- LEFT CONTENT -->
        <div class="leftContent scrollable col">

          <table class="table">
            <thead>
              <tr>
                <th>Opportunity and Student</th>
              </tr>
            </thead>
            <tbody id="tableBody">

            <?php
            // $conversationID
            $sql = "
            SELECT studentFirstName, studentLastName, jobTitle, conversationID, conversationStudentID, conversationCompanyID
            FROM jobs, conversations, students
            WHERE jobID = conversationJobID AND studentID = conversationStudentID AND '" . $uid . "' = conversationCompanyID
            ";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  // ' . $row['conversationID'] . '
                  echo '<tr class="clickable-row" data-test="test data" data-convo="' . $row['conversationID'] . '"><td><b>' . $row['jobTitle'] . '</b><br>' . $row['studentFirstName'] . " " . $row['studentLastName'] . '</td>';
                }
            } else {
                echo "0 results";
            }
            $con->close();
            ?>

            </tbody>
          </table>

        </div> <!-- END OF LEFT CONTENT -->

        <!-- RIGHT CONTENT -->
        <div class="rightContent col">
          <div id="conversationHeader" class="">

          </div>
          <div id="seeMessagesDiv" class="scrollable">

            <?php
            $sql = "
            SELECT messageContent, messageSenderID, messageTime
            FROM messages
            WHERE conversationID = '" . $conversationID . "'
            AND conversationStudentID = '" . $uid . "'
            ORDER BY messageTime ASC";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<div><h4>Sender: </h4><h4>Time: </h4><p>Message: </p></div>';
                  // echo '<tr class="clickable-row" data-test="test data" data-convo="' . $row['conversationID'] . '"><td><b>' . $row['jobTitle'] . '</b><br>' . $row['companyName'] . '</td>';
                }
            } else {
                echo "0 results";
            }
            $con->close();
            ?>

          </div>
          <div id="sendMessageDiv">
            <form id="sendMessageForm" class="" action="../includes/handlers/message-handler.php" method="post">
              <label for="messageContent">Enter your message:</label>
              <input id="conversationIDInput" type="hidden" name="conversationIDInput" value="Test">
              <input type="text" name="messageContent" value="">
              <input type="submit" name="sendMessage" value="Send!">
            </form>
          </div>

        </div> <!-- END OF RIGHT CONTENT -->

      </div> <!-- END OF MAIN CONTENT -->

    </div> <!-- END OF CONTAINER -->










  </body>
</html>
