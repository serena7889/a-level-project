<?php

require '../includes/config.php';
require '../includes/login-checks/student-login-check.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>

<?php

echo $_SESSION['studentLoggedIn'];
echo $_SESSION['id'];

 ?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand bg-dark navbar-dark">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link active" href="index.php">HOME</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="work-experience-list.php">WORK EXPERIENCE</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="jobs-list.php">JOBS</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="conversations.php">CONVERSATIONS</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="profile.php">PROFILE</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../includes/logout.php">LOGOUT</a>
		</li>
	</ul>
</nav>

</body>
</html>
