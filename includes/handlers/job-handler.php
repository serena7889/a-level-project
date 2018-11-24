<?php

$errorArray = array();

// function deleteOpportunity($con, $opportunityID) {
//
// 	$sql = "DELETE FROM opportunities WHERE opportunityID = '$opportunityID'";
// 	$result = $con->query($sql);
//
// 	if ($result) {
//     echo "Record deleted successfully";
// 	} else {
//     echo "Error deleting record: " . $con->error;
// }
// 	return $result;
// }

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

if (isset($_POST['addJobButton'])) {

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
  $errorArray = validateLongString($errorArray, $jobTimings, $jobTimingsLength);
  $errorArray = validateShortString($errorArray, $jobLocation, $jobLocationLength);

	if (empty($errorArray)) {
		$sql = "INSERT INTO jobs(jobCompanyID, jobTitle, jobDescription, jobRequirements, jobWages, jobTimings, jobLocation)
    VALUES('$uid', '$jobTitle', '$jobDescription', '$jobRequirements', '$jobWages', '$jobTimings', '$jobLocation')";
		$result = $con->query($sql);
    if ($result) {
      header('Location: index.php');
    }
	}
}

if (isset($_POST['deleteJobButton'])) {

}

?>
