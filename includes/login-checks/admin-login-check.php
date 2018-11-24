<?php

if (isset($_SESSION['adminLoggedIn'])) {
    $email = $_SESSION['adminLoggedIn'];
    $uid = $_SESSION['id'];
    $level= $_SESSION['level'];

} else {
    header('Location: login.php');
}

?>
