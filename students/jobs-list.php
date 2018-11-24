<?php
require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';
?>


<html lang="en" dir="ltr">
  <head>
    <title>Jobs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../includes/css/list-and-details.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script>

    $(document).ready(function(){
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableBody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $(".clickable-row").on("click", function() {
        $('#selectHint').addClass("hidden");
        $(".details").removeClass("hidden");
        var id = $(this).data("id");
        var companyID = $(this).data("cid");
        var company = $(this).data("company");
        var title = $(this).data("title");
        var description = $(this).data("description");
        var requirements = $(this).data("requirements");
        var timings = $(this).data("timings");
        var wages = $(this).data("wages");
        var location = $(this).data("location");
        $("#company").text(company);
        $("#title").text(title);
        $("#description").text(description);
        $("#requirements").text(requirements);
        $("#timings").text(timings);
        $("#wages").text(wages);
        $("#location").text(location);
        // set interested btn link
        $("#interestedForm").attr('action', `../includes/handlers/conversation-handler.php?isJob=true&jobID=${id}&companyID=${companyID}`);

      });




    });

    </script>

  </head>

  <body>

<?php include '../includes/headers/student-header.php'; ?>

    <!-- CONTAINER -->
    <div class="container">

      <!-- TOP CONTENT -->
      <div class="topContent">

        <h1>Find a job opportunity...</h1>
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
                <th>Opportunity and Company</th>
              </tr>
            </thead>
            <tbody id="tableBody">
            <?php
            $sql = "
            SELECT jobID, companyID, companyName, jobTitle, jobDescription, jobRequirements, jobTimings, jobWages, jobLocation
            FROM jobs, companies
            WHERE companyID = jobCompanyID
            ";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['opportunityID'];
                    // echo $id;
                    echo '
                  <tr class="clickable-row" data-id="' . $row['jobID'] . '" data-cid="' . $row['companyID'] . '" data-company="' . $row['companyName'] . '" data-title="' . $row['jobTitle'] . '" data-description="' . $row['jobDescription'] .
                  '" data-requirements="' . $row['jobRequirements'] . '" data-wages="' . $row['jobWages'] . '" data-location="' . $row['jobLocation'] . '" data-timings="' . $row['jobTimings'] . '">
                  <td><b>' . $row['jobTitle'] . '</b><br>' . $row['companyName'] . '</td>
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

          <h3 id="selectHint">Select a job opportunity to find out more...</h3>

          <!-- COMPANY DETAILS -->
          <h1 class="hidden details" id="title"></h1>
          <h3 class="hidden details" id="company"></h3>
          <br>

          <h3 class="hidden details">Job Description:</h3>
          <p class="hidden details" id="description"></p>

          <h3 class="hidden details">Job requirements:</h3>
          <p class="hidden details" id="requirements"></p>

          <h3 class="hidden details">Timings:</h3>
          <p class="hidden details" id="timings"></p>

          <h3 class="hidden details">Wages:</h3>
          <p class="hidden details" id="wages"></p>

          <h3 class="hidden details">Location:</h3>
          <p class="hidden details" id="location"></p>

          <!-- CHANGE FORM ACTION -->
          <form id="interestedForm" class="hidden details" action="" method="post">
            <input id="interestedBtn" type="submit" name="interestedInput" value="I'm interested...">
          </form>


        </div> <!-- END OF RIGHT CONTENT -->

      </div> <!-- END OF MAIN CONTENT -->

    </div> <!-- END OF CONTAINER -->

  </body>
</html>
