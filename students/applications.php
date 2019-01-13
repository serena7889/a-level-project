<?php

require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';

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

      if (status == 'accepted') {
        $("#accepted").addClass("selected");
        $("#declined").removeClass("selected");
        $("#undecided").removeClass("selected");
      } else if (status == "undecided") {
        $("#undecided").addClass("selected");
        $("#declined").removeClass("selected");
        $("#accepted").removeClass("selected");
      } else if (status == "declined") {
        $("#declined").addClass("selected");
        $("#accepted").removeClass("selected");
        $("#undecided").removeClass("selected");
      }

      $.ajax({
        type:"POST",
        url: "php-scripts/get-applications-table.php",
        data: {
          status: status
        },
        success: function(data, status){
          console.log('made it back here');
          $("#applications_table_container").html(data);
        }
      })

    }

    $(document).ready(function() {

      showTable('accepted');

    })

    </script>
    <title>APPLICATIONS</title>
  </head>

  <body>
    <?php
    include '../includes/headers/student-header.php';
     ?>
     <div class="container">
       <h1>Applications</h1>

       <div class="buttons">
         <button id="accepted" class="col" type="button" name="button" onclick="showTable('accepted')">Accepted</button>
         <button id="undecided" class="col" type="button" name="button" onclick="showTable('undecided')">Undecided</button>
         <button id="declined" class="col" type="button" name="button" onclick="showTable('declined')">Declined</button>
       </div>

       <div id="applications_table_container"></div></div>
     </div>
  </body>
</html>
