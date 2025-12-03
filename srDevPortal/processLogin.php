<?php
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();

    // get email
    $email = isset($_POST['ritEmail']) ? trim($_POST['ritEmail']) : '';

    // get id
    $id = strstr($email, "@", true);

    // validation
    if ($email === '') {
        // if empty redirect back
        header("Location: login.php?error=1");
        exit;
    }

    // store session
    $_SESSION['logged_in'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $id;

    // redirect to index
    header("Location: index.php");
    exit;
?>