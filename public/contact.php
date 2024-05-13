<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$page = file_get_contents($protocol . $_SERVER['SERVER_NAME'] . '/contact');
echo $page;
