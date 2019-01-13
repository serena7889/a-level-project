<?php

require '../../includes/config.php';
require '../../includes/login-checks/admin-login-check.php';

$sql = "
SELECT adminID, adminFirstName, adminLastName
FROM admins
";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="list_item_container" data-admin="' . $row['adminID'] . '">
        <h5>' . $row['adminFirstName'] . ' ' . $row['adminLastName'] . '</h5>
    </div>';
  }
} else {
  echo '0 results';
}
$con->close();
?>
