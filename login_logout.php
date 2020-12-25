<?php
// ob_start();
session_start();


// login
$msg = '';

if (
    isset($_POST['login']) && !empty($_POST['username'])
    && !empty($_POST['password'])
) {

    if (
        $_POST['username'] == 'tadas' &&
        $_POST['password'] == '1234'
    ) {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = 'tadas';
    } else {
        $msg = 'Wrong password or username';
    }
}

//logout
if (isset($_GET['action']) and $_GET['action'] == 'logout') {
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['valid']);
}

?>