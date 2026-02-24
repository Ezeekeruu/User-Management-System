<?php

session_start();

if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] == "admin") {

        header("Location: admin_users.php");

    } else {

        header("Location: profile.php");

    }

} else {

    header("Location: login.php");

}

exit();

?>