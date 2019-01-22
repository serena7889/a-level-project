<?php
require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';
?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="../includes/css/applications.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>

    function showTable(status) {

      if (status == 'active') {
        $("#active").addClass("selected");
        $("#ended").removeClass("selected");
      } else if (status == "ended") {
        $("#ended").addClass("selected");
        $("#active").removeClass("selected");
      }

      $.ajax({
        type:"POST",
        url: "php-scripts/get-conversations-table.php",
        data: {
          status: status
        },
        success: function(data){
          $("#conversations_table_container").html(data);
        }
      })

    }

    $(document).ready(function() {

      showTable('active');

    })

    </script>
    <title>CONVERSATIONS</title>
  </head>

  <body>
    <?php
    include '../includes/headers/admin-header.php';
     ?>
     <div class="container">
       <h1>Conversations</h1>

       <div class="buttons">
         <button id="active" class="col" type="button" onclick="showTable('active')">Active</button>
         <button id="ended" class="col" type="button" onclick="showTable('ended')">Ended</button>
       </div>

       <div id="conversations_table_container"></div></div>
     </div>
  </body>
</html>
