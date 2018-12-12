<?php

if (isset($_SESSION['adminLoggedIn']) and ($_SESSION['level'] == '1')) {
    $email = $_SESSION['adminLoggedIn'];
    $uid = $_SESSION['id'];
    $level= $_SESSION['level'];

} else {
    header('Location: login.php');
}

?>
