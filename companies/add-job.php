<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';
include '../includes/constants.php';
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/job-handler.php';

?>

<html>
<head>
	<title>ADD A JOB</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../includes/css/forms.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include '../includes/headers/company-header.php';
?>

<h1>Add a new job oportunity...</h1>

<div class="row">
	<div class="col">
		<form id="opportunityForm" action="add-job.php" method="POST">

			<div class="row">

				<div class="col">

					<div>
				    <label for="jobTitle">Title: </label>
						<?php echo getError($errorArray, $jobTitleLength); ?>
				    <input id="jobTitle" type="text" name="jobTitle" placeholder="" value="<?php getValue('jobTitle'); ?>" required>
				  </div>

					<div>
						<label for="jobDescription">Description: </label>
						<?php echo getError($errorArray, $jobDescriptionLength); ?>
						<textarea id="jobDescription" type="text" name="jobDescription" rows="8"><?php getValue('jobDescription'); ?></textarea>
					</div>

					<div>
						<label for="jobRequirements">Requirements: </label>
						<?php echo getError($errorArray, $jobRequirementsLength); ?>
						<textarea id="jobRequirements" type="text" name="jobRequirements" rows="8"><?php getValue('jobRequirements'); ?></textarea>
					</div>

				</div>

				<div class="col">

					<div>
						<label for="jobWages">Wages: </label>
						<?php echo getError($errorArray, $jobWagesLength); ?>
						<textarea id="jobWages" class="small" type="text" name="jobWages"><?php getValue('jobWages'); ?></textarea>
					</div>

					<div>
						<label for="jobTimings">Timings: </label>
						<?php echo getError($errorArray, $jobTimingsLength); ?>
						<textarea id="jobTimings" class="small" type="text" name="jobTimings"><?php getValue('jobTimings'); ?></textarea>
					</div>

					<div>
						<label for="jobLocation">Location: </label>
						<?php echo getError($errorArray, $jobLocationLength); ?>
						<textarea id="jobLocation" class="small" type="text" name="jobLocation"><?php getValue('jobLocation'); ?></textarea>
					</div>

					<button type="submit" name="addJobButton">CREATE!</button>

				</div>

			</div>

		</form>

	</div>
</div>

</body>
</html>
