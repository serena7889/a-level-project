<?php

require '../includes/config.php';
require '../includes/login-checks/company-login-check.php';

?>

<html>
<head>
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
	<link rel="stylesheet" href="../includes/css/home.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include '../includes/headers/company-header.php';

echo '<div class="container"><div class="central_container">';

$getNameAndWEQuery = "
	SELECT companyName, companyOffersWorkExperience AS we
	FROM companies
	WHERE companyID = '$uid'";

$result = $con->query($getNameAndWEQuery);
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$name = $row['companyName'];
  $we = ($row['we'] == 'yes' ? '' : 'do not');
	echo '<h1>Welcome, ' . $name . '!</h1>';
	echo '<h4>You ' . $we . ' offer work experience.</h4>';
}


$getJobCountQuery = "
	SELECT COUNT(jobID) AS jobCount
	FROM jobs
	WHERE jobCompanyID = '$uid'";

$result = $con->query($getJobCountQuery);
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$jobCount = $row['jobCount'];
	if ($jobCount > 0) {
		echo '<h4>You have posted ' . $jobCount . ' jobs.</h4>';
	}
}

$getConversationCountQuery = "
	SELECT COUNT(conversationID) AS convoCount
	FROM conversations
	WHERE conversationCompanyID = '$uid'";

$result = $con->query($getConversationCountQuery);
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$convoCount = $row['convoCount'];
	if ($convoCount > 0) {
		echo '<h4>You are part of ' . $convoCount . ' active conversations.</h4>';
	}
}

$getApplicationNumbersQuery = "
	SELECT applicationStatus, COUNT(applicationID) AS numApplications
	FROM applications, conversations
	WHERE conversationCompanyID = '$uid' AND conversationID = applicationConversationID
	GROUP BY applicationStatus
	ORDER BY numApplications DESC
";
$result = $con->query($getApplicationNumbersQuery);
if ($result->num_rows > 0) {
	echo '<h4>You have:</h4>';
	while ($row = $result->fetch_assoc()) {
		$status = $row['applicationStatus'];
		$numApplications = $row['numApplications'];
		echo '<h5>' . $numApplications . ' ' . $status . ' applications</h5>';
	}
}
echo '</div></div>';
?>

</body>
</html>
