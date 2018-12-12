<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';
include '../includes/constants.php';
// include '../includes/classes/Constants.php';
include '../includes/handlers/job-handler.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>ADD A JOB</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="../includes/css/list-and-details.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<?php

function getValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

include '../includes/headers/company-header.php';
?>

<form id="opportunityForm" action="add-job.php" method="POST">
	<h2>Add a new job oportunity...</h2>

  <div>
		<?php echo getError($errorArray, $jobTitleLength); ?>
    <label for="jobTitle">Title: </label>
    <input id="jobTitle" type="text" name="jobTitle" placeholder="" value="<?php getValue('jobTitle'); ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobDescriptionLength); ?>
    <label for="jobDescription">Description: </label>
    <input id="jobDescription" type="text" name="jobDescription" placeholder="" value="<?php getValue('jobDescription'); ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobRequirementsLength); ?>
    <label for="jobRequirements">Requirements: </label>
    <input id="jobRequirements" type="text" name="jobRequirements" placeholder="" value="<?php getValue('jobRequirements'); ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobWagesLength); ?>
    <label for="jobWages">Wages: </label>
    <input id="jobWages" type="text" name="jobWages" placeholder="" value="<?php getValue('jobWages'); ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobTimingsLength); ?>
    <label for="jobTimings">Timings: </label>
    <input id="jobTimings" type="text" name="jobTimings" placeholder="" value="<?php getValue('jobTimings'); ?>" required>
  </div>

  <div>
		<?php echo getError($errorArray, $jobLocationLength); ?>
    <label for="jobLocation">Location: </label>
    <input id="jobLocation" type="text" name="jobLocation" placeholder="" value="<?php getValue('jobLocation'); ?>" required>
  </div>

	<button type="submit" name="addJobButton">CREATE!</button>

</form>

</body>
</html>
