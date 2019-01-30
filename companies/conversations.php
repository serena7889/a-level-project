<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="../includes/css/list-and-details.css">
    <link rel="stylesheet" href="../includes/css/conversations.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <title>CONVERSATIONS</title>

    <script type="text/javascript">

    function getConversations() {
      $.ajax({
        type: "POST",
        url: "php-scripts/get-conversations.php",
        data: {
          conversationID: conversationID
        },
        success: function(data, status) {
          $("#list").html(data);
        }
      });
    };

    function getConversationHeader(conversationID) {
      $.ajax({
        type: "POST",
        url: "php-scripts/get-conversation-header.php",
        data: {
          conversationID: conversationID
        },
        success: function(data, status) {
          $("#right_header").html(data);
        }
      });
    };

    function getMessages(conversationID) {
      $.ajax({
        type: "POST",
        url: "php-scripts/get-messages.php",
        data: {
          conversationID: conversationID
        },
        success: function(data, status) {
          $("#middle_container").html(data);
        }
      });
    };

    function getBottomContainer(conversationID){
      $.ajax({
        type: "POST",
        url: "php-scripts/get-message-bottom-container.php",
        data: {
          conversationID: conversationID
        },
        success: function(data, status) {
          $("#bottom_container").html(data);
        }
      });
    };

    function sendMessage(conversationID) {

      var messageContent = $("#message_content").val();

      if (messageContent != "") {
        $("#message_content").val("");

        $.ajax({
          type: "POST",
          url: "php-scripts/send-message.php",
          data: {
            conversationID: conversationID,
            content: messageContent
          }
        });

        $('#middle_container').animate({
          scrollTop: $('#middle_container')[0].scrollHeight
        });
      };
    };

    function changeStatus(conversationID, newStatus)
    {
      console.log('status' + newStatus);
      $.ajax({
        type: "POST",
        url: "php-scripts/change-application-status.php",
        data: {
          conversationID: conversationID,
          newStatus: newStatus
        },
        success: function() {
          window.location.replace('applications.php');
        }
      });
    };

    function end(conversationID) {
      $.ajax({
        type: "POST",
        url: "php-scripts/end-conversation.php",
        data: {
          conversationID: conversationID
        },
        success: function() {
          location.reload();
        }
      });
    };

    function hideRightDisplay(bool) {
      $('#right_header').attr('hidden', bool);
      $('#middle_container').attr('hidden', bool);
      $('#bottom_container').attr('hidden', bool);
    };

    function showStudentDetails(conversationID) {
      $("#modal").attr('hidden', false);
      $.ajax({
        type:"POST",
        url: "php-scripts/get-student-details.php",
        data: {
          conversationID: conversationID
        },
        success: function(data, status){
          $("#modal_details").html(data);
        }
      });
    };

    function showOpportunityDetails(conversationID) {
      $("#modal").attr('hidden', false);
      $.ajax({
        type:"POST",
        url: "php-scripts/get-opportunity-details.php",
        data: {
          conversationID: conversationID
        },
        success: function(data, status) {
          $("#modal_details").html(data);
        }
      })
    }

    $(document).ready(function() {

      // GETS AND DISPLAYS LIST OF CONVERSATIONS
      $.ajax({
        type:"GET",
        url: "php-scripts/get-conversations.php",
        async: false,
        cache: false,
        success: function(data, status){
          document.getElementById("list").innerHTML = data;
        }
      })

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
        }
      })

      // SET UP THE MODAL CLOSE BUTTON
      $("#close").click(function() {
        $("#modal").attr('hidden', true);
      })

      // VARIABLE THAT WILL CONTAIN MESSAGE REFRESHING INTERVAL
      var getMessageInterval;

      // WHEN A CONVERSATION IS SELECTED
      $(".list_item_container").on("click", function() {

        // STOPS REFRESHING MESSAGES FROM PREVIOUS CONVERSATION
        clearInterval(getMessageInterval);

        // HIDES RIGHT CONTENT
        hideRightDisplay(true);

        // GETS IDS FROM SELECTED CONVERSATION
        var conversationID = $(this).data("convo");

        // GETS HEADER FOR SELECTED CONVERSATION AND SETS UP BUTTONS
        getConversationHeader(conversationID);

        // GETS SEND MESSAGE CONTAINER OR MESSAGE
        getBottomContainer(conversationID);

        // START REPEATEDLY GETTING MESSAGES FOR SELECTED CONVERSATION
        getMessageInterval = setInterval(function() {
          getMessages(conversationID);
        }, 400);

        // SHOWS RELEVANT SECTIONS
        hideRightDisplay(false);

        // WAITS THEN SCROLLS TO BOTTOM OF MESSAGES
        setTimeout(function() {
          $('#middle_container').animate({
            scrollTop: $('#middle_container')[0].scrollHeight,
          });
        }, 800);

      });
    });
    </script>

  </head>

  <body>

    <?php
    include '../includes/headers/company-header.php';
    ?>

    <div class="left_container">

      <div class="left_header">
        <h1>Conversations</h1>
        <div class="search_bar_container">
          <input id="search_bar" type="text" class="search_bar" placeholder="Search">
        </div>
      </div>

      <div id="list" class="list"></div>

    </div>

    <div class="right_container col-sm-8">

      <div id="right_header" class="right_header" hidden></div>

      <div id="middle_container" class="middle_container" hidden></div>

      <div id="bottom_container" class="bottom_container" hidden></div>

    </div>

    <div id="modal" class="modal" hidden>
      <div class="modal_content">
        <span id="close">&times;</span>
        <div id="modal_details"></div>
      </div>
    </div>

  </body>
</html>
