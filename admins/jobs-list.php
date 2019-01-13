<?php
require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../includes/css/list-and-details.css">
    <title>JOBS</title>
    <script type="text/javascript">

    $(document).ready(function() {

      $.ajax({
        type: "GET",
        url: "php-scripts/get-jobs-list.php",
        async: false,
        cache: false,
        success: function(data) {
          document.getElementById("list").innerHTML = data;
        }
      });

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

      $(".list_item_container").click(function() {
        var jobID = $(this).data("job");

        $.ajax({
          type: "POST",
          url: "php-scripts/get-job-details.php",
          data: {
            jobID: jobID
          },
          success: function(data) {
              document.getElementById("right_container").innerHTML = data;
          }
        });

      });

    });

    function editJob(jobID) {
      console.log('job id: '+jobID);
      window.location.replace("edit-job.php?jobID="+jobID);
    }

    </script>

  </head>

  <body>

    <?php
    include '../includes/headers/admin-header.php';
    ?>

      <div class="left_container">

        <div class="left_header">
          <h1>Jobs</h1>
          <div class="search_bar_container">
            <input id="search_bar" type="text" class="search_bar" placeholder="Search">
          </div>
        </div>

        <div id="list" class="list">

        </div>

      </div>

      <div id="right_container" class="right_container">

      </div>

  </body>
</html>
