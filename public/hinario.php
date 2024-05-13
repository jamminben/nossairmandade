<?php

if (isset($_REQUEST['hid'])) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $page = file_get_contents($protocol . $_SERVER['SERVER_NAME'] . '/hinario/' . $_REQUEST['hid']);
    echo $page;
} else {
    header('Location: http://' . $_SERVER['SERVER_NAME'] . '.com');
    exit();
}

