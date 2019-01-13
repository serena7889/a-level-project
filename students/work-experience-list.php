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
    <link rel="stylesheet" href="../includes/css/list-and-details.css">
    <title>WORK EXPERIENCE</title>
    <script type="text/javascript">

    $(document).ready(function() {

      $.ajax({
        type: "GET",
        url: "php-scripts/get-work-experience-list.php",
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

      $(".list_item_container").click(function(){
        var companyID = $(this).data("company");
        $.ajax({
          type: "POST",
          url: "php-scripts/get-work-experience-details.php",
          data: {
            companyID: companyID
          },
          success: function(data) {
              document.getElementById("right_container").innerHTML = data;
          }
        });
      });

    });

    function createConversation(companyID) {
      $.ajax({
        type: "POST",
        url: "php-scripts/create-conversation.php",
        data: {
          companyID: companyID
        },
        success: function() {
          window.location.replace("conversations.php");
        }
      });
    };

    </script>

  </head>

  <body>

    <?php
    include '../includes/headers/student-header.php';
    ?>

      <div class="left_container">

        <div class="left_header">
          <h1>Companies</h1>
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








<!-- <html lang="en" dir="ltr">
  <head>
    <title>Work Experience</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../includes/css/list-and-details.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script>

    // filters company table by user search
    $(document).ready(function(){
      $(".companyDetailsHeaders").hide();
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableBody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      // sets details when company clicked
      $(".clickable-row").on("click", function() {
        $('#selectHint').addClass("hidden");
        $(".details").removeClass("hidden");
        var companyID = $(this).data("cid");
        var name = $(this).data("name");
        var about = $(this).data("about");
        var description = $(this).data("description");
        var requirements = $(this).data("requirements");
        $("#name").text(name);
        $("#about").text(about);
        $("#description").text(description);
        $("#requirements").text(requirements);
        $("#interestedForm").attr('action', `../includes/handlers/conversation-handler.php?isJob=false&companyID=${companyID}`);

        // $("#interestedForm").attr('action', `../includes/handlers/conversation-handler.php?isJob=false&companyID=${companyID}`);
      });

      function hideOnRowClicked() {
        var x = document.getElementByClassName("details");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
      }



    });

    </script>

  </head>

  <body>

    <?php
    // include '../includes/headers/student-header.php';
    ?>

    <div class="container">

      <div class="topContent">

        <h1>Find a work experience opportunity...</h1>
        <h3>Start entering a company name or job title...</h3>
        <input class="form-control" id="searchInput" type="text" placeholder="Search..">

      </div>

      <div class="mainContent row">

        <div class="leftContent scrollable col">

          <table class="table">
            <thead>
              <tr>
                <th>Company</th>
              </tr>
            </thead>
            <tbody id="tableBody">
            <?php
            // $sql = "
            // SELECT companyID, companyName, companyAbout, companyWorkExperienceDescription, companyWorkExperienceRequirements
            // FROM companies
            // WHERE companyOffersWorkExperience = 'yes'
            // ORDER BY companyName ASC
            // ";
            // $result = $con->query($sql);
            //
            // if ($result->num_rows > 0) {
            //     while ($row = $result->fetch_assoc()) {
            //         $id = $row['opportunityID'];
            //         echo '
            //       <tr class="clickable-row" data-cid="' . $row['companyID'] . '" data-name="' . $row['companyName'] . '" data-about="' . $row['companyAbout'] . '" data-description="' . $row['companyWorkExperienceDescription'] . '" data-requirements="' . $row['companyWorkExperienceRequirements'] . '">
            //       <td>' . $row['companyName'] . '</td>
            //       </tr>';
            //     }
            // } else {
            //     echo "0 results";
            // }
            // $con->close();
            ?>

            </tbody>
          </table>

        </div>

        <div class="rightContent scrollable col">
          <h3 id="selectHint">Select a company to find out about their work experience opportunities...</h3>


          <h1 class="hidden details" id="name"></h1>
          <br>

          <h3 class="hidden details">About this company:</h3>
          <p class="hidden details" id="about"></p>

          <h3 class="hidden details">Work experience description:</h3>
          <p class="hidden details" id="description"></p>

          <h3 class="hidden details">Work experience requirements:</h3>
          <p class="hidden details" id="requirements"></p>


          <form id="interestedForm" class="hidden details" method="post">
            <input id="interestedBtn" type="submit" name="interestedInput" value="I'm interested...">
          </form>


        </div>

      </div>

    </div>

  </body>




</html> -->
