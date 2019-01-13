<?php

require '../../includes/config.php';
require '../../includes/login-checks/company-login-check.php';

$sql = "
SELECT jobID, companyName, jobTitle
FROM jobs, companies
WHERE companyID = jobCompanyID AND jobActive = 'yes'
";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="list_item_container" data-job="' . $row['jobID'] . '">
      <h5>' . $row['jobTitle'] . '</h5>
      <p>' . $row['companyName'] . '</p>
    </div>';
  }
} else {
  echo '0 results';
}
$con->close();
?>
