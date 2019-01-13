<?php

$errorArray = array();

function getError($errorArray, $error){
	if (!in_array($error, $errorArray))
		$error = "";
		return "<span class='errorMessage'>$error</span>";
}


function validateShortString($errorArray, $string, $error){
		if(strlen($string) > 100 || strlen($string) < 1) {
			array_push($errorArray, $error);
		}
    return $errorArray;
}

function validateLongString($errorArray, $string, $error){
		if(strlen($string) > 500 || strlen($string) < 1) {
			array_push($errorArray, $error);
		}
    return $errorArray;
}

if (isset($_POST['addJobButton']) || isset($_POST['updateJobButton']) || isset($_POST['deleteJobButton'])) {

  $jobTitle = $_POST['jobTitle'];
  $jobDescription = $_POST['jobDescription'];
  $jobRequirements = $_POST['jobRequirements'];
  $jobWages = $_POST['jobWages'];
  $jobTimings = $_POST['jobTimings'];
  $jobLocation= $_POST['jobLocation'];

  $errorArray = validateShortString($errorArray, $jobTitle, $jobTitleLength);
  $errorArray = validateLongString($errorArray, $jobDescription, $jobDescriptionLength);
  $errorArray = validateLongString($errorArray, $jobRequirements, $jobRequirementsLength);
  $errorArray = validateShortString($errorArray, $jobWages, $jobWagesLength);
  $errorArray = validateShortString($errorArray, $jobTimings, $jobTimingsLength);
  $errorArray = validateShortString($errorArray, $jobLocation, $jobLocationLength);

	if (empty($errorArray)) {

		if (isset($_POST['addJobButton'])) {

			$addJobQuery = "
			INSERT INTO jobs(jobCompanyID, jobTitle, jobDescription, jobRequirements, jobWages, jobTimings, jobLocation)
	    VALUES('$uid', '$jobTitle', '$jobDescription', '$jobRequirements', '$jobWages', '$jobTimings', '$jobLocation')";
			$result = $con->query($addJobQuery);

		} else if (isset($_POST['updateJobButton']) || isset($_POST['deleteJobButton'])) {

			$jobID = $_POST['jobID'];

			$setOldInactiveQuery = "
			UPDATE jobs
			SET jobActive = 'no'
			WHERE jobID = '$jobID';
			";
			$result = $con->query($setOldInactiveQuery);

			if (isset($_POST['updateJobButton'])) {
				$addNewVersionQuery = "
				INSERT INTO jobs(jobCompanyID, jobTitle, jobDescription, jobRequirements, jobWages, jobTimings, jobLocation)
				VALUES('$uid', '$jobTitle', '$jobDescription', '$jobRequirements', '$jobWages', '$jobTimings', '$jobLocation');
				";
				$result = $con->query($addNewVersionQuery);
			}

		}

		if ($result) {
			header('Location: jobs-list.php');
		}
	}
}

?>
