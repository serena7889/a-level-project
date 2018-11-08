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
echo 'student home page';
 // echo $username;
// include '../includes/headers/student_header.php';
//
// $sql = "SELECT studentFirstName, studentLastName FROM students WHERE studentID = '$uid'";
// $result = $con->query($sql);
//
// if ($result->num_rows > 0) {
//
//     $row = $result->fetch_assoc();
//     $fname = $row['studentFirstName'];
//     $lname = $row['studentLastName'];
//
//     echo "<h1>Welcome, {$fname} {$lname}!</h1>";
//
// } else {
//
//     echo "Problem getting name";
//
// }

?>

</body>
</html>
