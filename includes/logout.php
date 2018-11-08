<?php
session_start();

if (isset($_SESSION['companyLoggedIn'])) {
    unset($_SESSION['companyLoggedIn']);
    unset($_SESSION['id']);
}

if (isset($_SESSION['studentLoggedIn'])) {
    unset($_SESSION['studentLoggedIn']);
    unset($_SESSION['id']);
}

if (isset($_SESSION['adminLoggedIn'])) {
    unset($_SESSION['adminLoggedIn']);
    unset($_SESSION['id']);
}

session_destroy();

header('Location: ../index.php');
