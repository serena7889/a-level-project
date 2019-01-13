<?php
require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/job-handler.php';
?>

<html>
<head>
	<title>EDIT JOB</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include '../includes/headers/company-header.php';

// GETS JOB ID FROM URL VARIABLE
$jobID = $_GET['jobID'];

// GETS JOB DETAILS FROM DATABASE
$getJobDetailsQuery = "
SELECT companyID, companyName, jobTitle, jobDescription, jobRequirements, jobTimings, jobWages, jobLocation
FROM jobs, companies
WHERE companyID = jobCompanyID AND jobID = '$jobID'
";
$result = $con->query($getJobDetailsQuery);

// THE RESULTS ARE ASSIGNED TO VARIABLES
if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $companyID = $row['companyID'];
  $companyName = $row['companyName'];
  $jobTitle = $row['jobTitle'];
  $jobDescription = $row['jobDescription'];
  $jobRequirements = $row['jobRequirements'];
  $jobTimings = $row['jobTimings'];
  $jobWages = $row['jobWages'];
  $jobLocation = $row['jobLocation'];

  if ($companyID != $uid) {
    header("Location: jobs-list.php");
  }
}
?>

<!-- THE DETAILS FORM WITH THE VALUES SET FROM THE DATABASE QUERY -->
<form id="opportunityForm" action="edit-job.php" method="POST">
	<h2>Update job details...</h2>

  <div>
		<?php echo getError($errorArray, $jobTitleLength); ?>
    <label for="jobTitle">Title: </label>
    <input id="jobTitle" type="text" name="jobTitle" placeholder="" value="<?php echo $jobTitle; ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobDescriptionLength); ?>
    <label for="jobDescription">Description: </label>
    <input id="jobDescription" type="text" name="jobDescription" placeholder="" value="<?php echo $jobDescription; ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobRequirementsLength); ?>
    <label for="jobRequirements">Requirements: </label>
    <input id="jobRequirements" type="text" name="jobRequirements" placeholder="" value="<?php echo $jobRequirements; ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobWagesLength); ?>
    <label for="jobWages">Wages: </label>
    <input id="jobWages" type="text" name="jobWages" placeholder="" value="<?php echo $jobWages; ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobTimingsLength); ?>
    <label for="jobTimings">Timings: </label>
    <input id="jobTimings" type="text" name="jobTimings" placeholder="" value="<?php echo $jobTimings; ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobLocationLength); ?>
    <label for="jobLocation">Location: </label>
    <input id="jobLocation" type="text" name="jobLocation" placeholder="" value="<?php echo $jobLocation; ?>" required>
  </div>

	<input type="text" name="jobID" value="<?php echo $jobID; ?>" hidden>

	<button type="submit" name="updateJobButton">UPDATE!</button>

	<button type="submit" name="deleteJobButton">DELETE!</button>

</form>

</body>
</html>
