<!-- include on pages restricted to students who are logged in -->

<?php

if (isset($_SESSION['studentLoggedIn'])) {
    $email = $_SESSION['studentLoggedIn'];
    $uid = $_SESSION['id'];
} else {
    header('Location: register.php');
}

?>
