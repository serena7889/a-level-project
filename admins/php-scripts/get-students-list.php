<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$sql = "
SELECT studentID, studentFirstName, studentLastName
FROM students
";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="list_item_container" data-student="' . $row['studentID'] . '">
        <h5>' . $row['studentFirstName'] . ' ' . $row['studentLastName'] . '</h5>
    </div>';
  }
} else {
  echo '0 results';
}
$con->close();
?>
