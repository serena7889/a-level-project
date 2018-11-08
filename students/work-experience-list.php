<?php

include '../includes/config.php';

?>


<html lang="en" dir="ltr">
  <head>
    <title>Work Experience</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/list-and-details.css">
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
        var name = $(this).data("name");
        var about = $(this).data("about");
        var description = $(this).data("description");
        var requirements = $(this).data("requirements");
        $("#name").text(name);
        $("#about").text(about);
        $("#description").text(description);
        $("#requirements").text(requirements);
      });

    });

    </script>

  </head>

  <body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand bg-dark navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="work-experience-list.php">WORK EXPERIENCE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="jobs-list.php">JOBS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="conversations.php">CONVERSATIONS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">PROFILE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../includes/logout.php">LOGOUT</a>
        </li>
      </ul>
    </nav>


    <!-- CONTAINER -->
    <div class="container">

      <!-- TOP CONTENT -->
      <div class="topContent">

        <h1>Find a work experience opportunity...</h1>
        <h3>Start entering a company name or job title...</h3>
        <input class="form-control" id="searchInput" type="text" placeholder="Search..">

      </div>

      <!-- MAIN CONTENT -->
      <div class="mainContent row">

        <!-- LEFT CONTENT -->
        <div class="leftContent scrollable col">

          <table class="table">
            <thead>
              <tr>
                <th>Company</th>
              </tr>
            </thead>
            <tbody id="tableBody">
            <?php
            $sql = "
            SELECT companyID, companyName, companyAbout, companyWorkExperienceDescription, companyWorkExperienceRequirements
            FROM companies
            WHERE companyOffersWorkExperience = 'yes'
            ORDER BY companyName ASC
            ";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['opportunityID'];
                    echo '
                  <tr class="clickable-row" data-id="' . $row['companyID'] . '" data-name="' . $row['companyName'] . '" data-about="' . $row['companyAbout'] . '" data-description="' . $row['companyWorkExperienceDescription'] . '" data-requirements="' . $row['companyWorkExperienceRequirements'] . '">
                  <td>' . $row['companyName'] . '</td>
                  </tr>';
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
        <div class="rightContent scrollable col">

          <h3 id="selectHint">Select a company to find out about their work experience opportunities...</h3>

          <!-- COMPANY DETAILS -->
          <h1 class="hidden details" id="name"></h1>
          <br>

          <h3 class="hidden details">About this company:</h3>
          <p class="hidden details" id="about"></p>

          <h3 class="hidden details">Work experience description:</h3>
          <p class="hidden details" id="description"></p>

          <h3 class="hidden details">Work experience requirements:</h3>
          <p class="hidden details" id="requirements"></p>

          <!-- CHANGE FORM ACTION -->
          <form class="hidden details" action="conversations.php" method="post">
            <input id="interested" type="submit" name="interestedInput" value="I'm interested...">
          </form>


        </div> <!-- END OF RIGHT CONTENT -->

      </div> <!-- END OF MAIN CONTENT -->

    </div> <!-- END OF CONTAINER -->

  </body>




</html>
