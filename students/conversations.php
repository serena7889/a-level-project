<?php
require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../includes/css/conversations.css">
    <title>CONVERSATIONS</title>
    <script type="text/javascript">

    $(document).ready(function(){

      var getMessageInterval;

      // WHEN A CONVERSATION IS SELECTED
      $(".conversation_container").on("click", function() {

        clearInterval(getMessageInterval);

        $('#messages_header').attr('hidden', true);
        $('#messages_container').attr('hidden', true);
        $('#send_message_container').attr('hidden', true);

        var conversationID = $(this).data("convo");

        // GETS HEADER FOR SELECTED CONVERSATION
        var data = "conversation="+conversationID;
        console.log(data);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("messages_header").innerHTML = this.responseText;
           };
        };
        xhttp.open("POST", "get-conversation-header.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(data);

        // STARTS REPEATEDLY GETTING MESSAGES FOR SELECTED CONVERSATION
        getMessageInterval = setInterval(function() {
          var data = "conversation="+conversationID;
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("messages_container").innerHTML = this.responseText;
             };
          };
          xhttp.open("POST", "get-messages.php", true);
          xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhttp.send(data);
        }, 400);

        // GETS THE ID OF THE CONVERSATION AND SETS UP THE SEND BUTTON
        $('#send_btn').attr('onclick', 'sendMessage('+conversationID+')');


        // SETS THE ENTER BUTTON TO ALSO SEND WHEN THE MESSAGE INPUT IS SELECTED
        var messageInput = document.getElementById("message_content");
        messageInput.addEventListener("keyup", function(event) {
          if (event.keyCode === 13) {
            document.getElementById("send_btn").click();
          }
        });

        // SHOWS RELEVANT SECTIONS
        $('#messages_header').attr('hidden', false);
        $('#messages_container').attr('hidden', false);
        $('#send_message_container').attr('hidden', false);

        // WAITS THEN SHOWS RELEVANT SECTIONS AND SCROLLS TO BOTTOM
        setTimeout(function() {
          $('#messages_container').animate({
            scrollTop: $('#messages_container')[0].scrollHeight,
          });
        }, 800);

      });
    });




    // function getConversations() {
    //   var xhttp = new XMLHttpRequest();
    //   xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         document.getElementById("tableBody").innerHTML = this.responseText;
    //     };
    //   };
    //   xhttp.open("POST", "get-conversations.php", true);
    //   xhttp.send();
    // };



    function getMessages(conversationID) {
      var data = "conversation="+conversationID;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("messages_container").innerHTML = this.responseText;
         }
      };
      xhttp.open("POST", "get-messages.php", true);
      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhttp.send(data);
    };



    function sendMessage(convoID) {
      var messageContent = document.getElementById("message_content").value;
      if (messageContent != "") {
        document.getElementById("message_content").value = "";
        var data = "conversation="+convoID+"&content="+messageContent;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange;
        xhttp.open("POST", "send-message.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(data);

        setTimeout(function() {
          $('#messages_container').animate({
            scrollTop: $('#messages_container')[0].scrollHeight,
          });
        }, 400);
      };
    };

    </script>

  </head>




  <body>

  <div class="container">

    <?php
    include '../includes/headers/student-header.php';
    ?>

    <div class="row">

      <div class="left_container col-sm-4">

        <div class="header">
          <h4>Conversations</h4>
        </div>

        <div class="conversations_list">
          <div class="conversation_list">
          <?php
          // DISPLAYS THE CONVERSATIONS
          // SQL query to get conversation details
          // Gets companyName, conversationID, conversationStudentID, conversationCompanyID, conversationLatestTime, conversationTitle

          $sql = "
          SELECT companyName, conversationID, conversationStudentID, conversationCompanyID, conversationLatestTime,
          COALESCE(jobTitle, 'Work Experience') AS conversationTitle
          FROM companies, conversations
          LEFT JOIN jobs ON jobID = conversationJobID
          WHERE conversationCompanyID = companyID and conversationStudentID = '$uid'
          ORDER BY conversationLatestTime DESC
          ";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $time = $row['conversationLatestTime'];
                $time = date("d M y", strtotime($time));

                // add active_conversation after chat_list
                echo '
                <div class="conversation_container" data-convo="' . $row['conversationID'] . '">
                  <div class="conversation">
                    <h5>' . $row['conversationTitle'] . '<span class="chat_date">' . $time . '</span></h5>
                    <p>' . $row['companyName'] . '</p>
                  </div>
                </div>';
              }
          } else {
              echo "0 results";
          }
          $con->close();
          ?>

          </div>
        </div>

      </div>

      <div class="right_container col-sm-8">
        <div id="messages_header" class="header" hidden>

        </div>
        <div id="messages_container" class="messages_container" hidden>

        </div>
        <div id="send_message_container" class="send_message_container" hidden>
          <input id="message_content" type="text" placeholder="Type a message...">
          <button id="send_btn" class="send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>

        </div>

      </div>

    </div>

  </div>







  </body>
</html>
