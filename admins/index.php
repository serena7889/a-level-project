<?php

require '../includes/config.php';
require '../includes/login-checks/admin-login-check.php';

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
include '../includes/headers/admin-header.php';
echo '<div class="container"><div class="central_container">';
		$getNameQuery = "SELECT adminFirstName, adminLastName FROM admins WHERE adminID = '$uid'";
		$result = $con->query($getNameQuery);
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$name = $row['adminFirstName'] . ' ' . $row['adminLastName'];
      echo '<h1>Welcome, ' . $name . '!</h1>';
		}
    echo '<h3>There are:</h3>';
    $getCompanyCount = "SELECT COUNT(companyID) AS companyCount FROM companies";
		$result = $con->query($getCompanyCount);
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$companyCount = $row['companyCount'];
      echo '<h5>' . $companyCount . ' companies</h5>';
		}
    $getStudentCount = "SELECT COUNT(studentID) AS studentCount FROM students";
		$result = $con->query($getStudentCount);
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$studentCount = $row['studentCount'];
      echo '<h5>' . $studentCount . ' students</h5>';
		}
    $getJobCount = "SELECT COUNT(jobID) AS jobCount FROM jobs WHERE jobActive = 'yes'";
		$result = $con->query($getJobCount);
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			 $jobCount = $row['jobCount'];
       echo '<h5>' . $jobCount . ' active jobs</h5>';
		}
    $getWECount = "SELECT COUNT(companyID) AS weCount FROM companies WHERE companyOffersWorkExperience = 'yes'";
		$result = $con->query($getWECount);
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			 $weCount = $row['weCount'];
       echo '<h5>' . $weCount . ' companies offering work experience</h5>';
		}
    if ($level == 1) {
      $getAdminCount = "SELECT COUNT(adminID) AS adminCount FROM admins WHERE adminLevel = '2'";
  		$result = $con->query($getAdminCount);
  		if ($result->num_rows == 1) {
  			$row = $result->fetch_assoc();
  			 $adminCount = $row['adminCount'];
         echo '<h5>' . $adminCount . ' level 2 admins</h5>';
  		}
    }
		$getApplicationNumbersQuery = "
			SELECT applicationStatus, COUNT(applicationID) AS numApplications
			FROM applications, conversations
			WHERE conversationID = applicationConversationID
			GROUP BY applicationStatus
			ORDER BY numApplications DESC";
		$result = $con->query($getApplicationNumbersQuery);
		if ($result->num_rows > 0) {
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
