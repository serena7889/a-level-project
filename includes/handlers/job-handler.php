<?php

$errorArray = array();

if (isset($_POST['addJobButton']) || isset($_POST['updateJobButton'])) {

  $jobTitle = sanitizeString($_POST['jobTitle']);
  $jobDescription = sanitizeString($_POST['jobDescription']);
  $jobRequirements = sanitizeString($_POST['jobRequirements']);
  $jobWages = sanitizeString($_POST['jobWages']);
  $jobTimings = sanitizeString($_POST['jobTimings']);
  $jobLocation= sanitizeString($_POST['jobLocation']);

  $errorArray = validateTextLength($errorArray, $jobTitleLength, $jobTitle, 2, 100);
  $errorArray = validateTextLength($errorArray, $jobDescriptionLength, $jobDescription, 50, 1000);
  $errorArray = validateTextLength($errorArray, $jobRequirementsLength, $jobRequirements, 50, 1000);
  $errorArray = validateTextLength($errorArray, $jobWagesLength, $jobWages, 2, 100);
  $errorArray = validateTextLength($errorArray, $jobTimingsLength, $jobTimings, 2, 100);
  $errorArray = validateTextLength($errorArray, $jobLocationLength, $jobLocation, 2, 100);
}

if (empty($errorArray)) {

	if (isset($_POST['addJobButton'])) {

		$addJobQuery = "
		INSERT INTO jobs(jobCompanyID, jobTitle, jobDescription, jobRequirements, jobWages, jobTimings, jobLocation)
		VALUES('$uid', '$jobTitle', '$jobDescription', '$jobRequirements', '$jobWages', '$jobTimings', '$jobLocation')";

		if ($con->query($addJobQuery)) {
			header("Location: jobs-list.php");
		}

	} else if (isset($_POST['updateJobButton']) || isset($_POST['deleteJobButton'])) {

		$jobID = $_POST['jobID'];

		$setOldInactiveQuery = "
		UPDATE jobs
		SET jobActive = 'no'
		WHERE jobID = '$jobID';
		";
		$con->query($setOldInactiveQuery);

		if (isset($_POST['updateJobButton'])) {
			$addNewVersionQuery = "
			INSERT INTO jobs(jobCompanyID, jobTitle, jobDescription, jobRequirements, jobWages, jobTimings, jobLocation)
			VALUES('$uid', '$jobTitle', '$jobDescription', '$jobRequirements', '$jobWages', '$jobTimings', '$jobLocation');
			";
			$con->query($addNewVersionQuery);
		}
		header("Location: jobs-list.php");
	}

}

?>
