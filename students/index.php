<?php

require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';

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
include '../includes/headers/student-header.php';
echo '<div class="container"><div class="central_container">';
// count(conversationID) as convoCount
$getNameQuery = "
	SELECT studentFirstName, studentLastName
	FROM students
	WHERE studentID = '$uid'
";
$result = $con->query($getNameQuery);
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$name = $row['studentFirstName'] . ' ' . $row['studentLastName'];
	// $convoCount = $row['convoCount'];
	echo '<h1>Welcome, ' . $name . '!</h1>';
	// echo '<h4>You are part of ' . $convoCount . ' active conversations.</h4>';
}
echo '<h4>You have:</h4>';
$getApplicationNumbersQuery = "
	SELECT applicationStatus, COUNT(applicationID) AS numApplications
	FROM applications, conversations
	WHERE conversationStudentID = '$uid' AND conversationID = applicationConversationID
	GROUP BY applicationStatus
	ORDER BY numApplications DESC
";
$result = $con->query($getApplicationNumbersQuery);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$status = $row['applicationStatus'];
		$numApplications = $row['numApplications'];
		echo '<h5>' . $numApplications . ' ' . $status . ' applications</h5>';
	}
} else {
	echo '<h5>No applications</h5>';
}


echo '</div></div>';
?>
</body>
</html>
