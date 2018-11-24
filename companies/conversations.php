<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

 ?>

<html lang="en" dir="ltr">
  <head>
    <title>Conversations</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../includes/css/list-and-details.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script type="text/javascript">


    $(document).ready(function() {
      var getMessageInterval = null;

      $("#stopRefreshing").on("click", function() {
        clearInterval(getMessageInterval);
      });

      // getConversations();

      $(".clickable-row").on("click", function() {
        clearInterval(getMessageInterval);

        // GET MESSAGES FOR SELECTED CONVERSATION
        getMessageInterval = setInterval(function() {
          var data = "conversation="+conversationID;
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("seeMessagesDiv").innerHTML = this.responseText;
             };
          };
          xhttp.open("POST", "get-messages.php", true);
          xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhttp.send(data);
        }, 800);


        $("#stopRefreshing").on("click", function() {
          clearInterval(getMessageInterval);
        });

        // GETS THE ID OF THE CONVERSATION AND SETS UP THE SEND BUTTON
        var conversationID = $(this).data("convo");
        $('#sendBtn').attr('onclick', 'sendMessage('+conversationID+')');

        // SHOWS THE MESSAGES AND THE SEND MESSAGE SECTION
        $("#sendMessageDiv").attr("hidden", false);
        $("#seeMessagesDiv").attr("hidden", false);

        // setInterval(getMessages(conversationID), 800);

      });
    });

    function getConversations() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableBody").innerHTML = this.responseText;
        };
      };
      xhttp.open("POST", "get-conversations.php", true);
      xhttp.send();
    };

    function getMessages(conversationID) {
      var data = "conversation="+conversationID;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("seeMessagesDiv").innerHTML = this.responseText;
         };
      };
      xhttp.open("POST", "get-messages.php", true);
      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhttp.send(data);
    };

    function sendMessage(convoID) {
      var messageContent = document.getElementById("messageContent").value;
      var data = "conversation="+convoID+"&content="+messageContent;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange;
      xhttp.open("POST", "send-message.php", true);
      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhttp.send(data);
    };


    </script>


  </head>
  <body>

    <?php include '../includes/headers/company-header.php'; ?>

    <div class="container">

      <!-- TOP CONTENT -->
      <!-- <div class="topContent"></div> -->

      <!-- MAIN CONTENT -->
      <div class="mainContent row">

        <!-- LEFT CONTENT -->
        <div class="leftContent scrollable col">

          <button id="stopRefreshing" type="button" name="button">Stop Refreshing</button>

          <table class="table">
            <thead>
              <tr>
                <th>CONVERSATIONS</th>
              </tr>
            </thead>
            <tbody id="tableBody">

            <!-- DISPLAYS THE CONVERSATIONS -->
            <?php
            $sql = "
            SELECT studentFirstName, studentLastName, jobTitle, conversationID, conversationStudentID
            FROM jobs, students, conversations
            WHERE jobID = conversationJobID AND studentID = conversationStudentID AND '" . $uid . "' = conversationCompanyID
            ";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<tr class="clickable-row" data-convo="' . $row['conversationID'] . '"><td><b>' . $row['jobTitle'] . '</b><br>' . $row['studentFirstName'] . ' ' . $row['studentLastName'] . '</td>';
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

          <div id="conversationHeader" class=""></div>

          <div id="seeMessagesDiv" class="scrollable" hidden></div>

          <div id="sendMessageDiv" hidden>
            <textarea id="messageContent" name="messsageContent" rows="3" cols="80"></textarea>
            <button id="sendBtn" type="button" name="sendBtn">Send!</button>
          </div>

        </div>

      </div>

    </div>

  </body>
</html>
