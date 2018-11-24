<?php
if (isset($_SESSION['companyLoggedIn'])) {
    $email = $_SESSION['companyLoggedIn'];
    $uid = $_SESSION['id'];
} else {
    header('Location: ../companies/register.php');
}

?>
