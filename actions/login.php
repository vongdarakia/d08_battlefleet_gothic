<?php
    require_once('auth.php');
    session_start();
    if (!($_POST['login'] && $_POST['passwd'] && auth($_POST['login'], $_POST['passwd']))) {
        $_SESSION['logged_on_user'] = "";
        header('Location: index.html');
        echo "ERROR\n";
    } else {
        $_SESSION['logged_on_user'] = $_POST['login'];
?>