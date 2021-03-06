<?php

require '../../includes/config.php';
require '../../includes/login-checks/student-login-check.php';

$sql = "
SELECT companyID, companyName
FROM companies
WHERE companyOffersWorkExperience = 'yes'
ORDER BY companyName ASC";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="list_item_container" data-company="' . $row['companyID'] . '">
        <h5>' . $row['companyName'] . '</h5>
        <p>Work Experience</p>
    </div>';
  }
} else {
  echo '0 results';
}
$con->close();
?>
