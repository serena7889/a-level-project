<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$sql = "
SELECT jobID, jobTitle, companyName
FROM companies, jobs
WHERE jobCompanyID = companyID
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
