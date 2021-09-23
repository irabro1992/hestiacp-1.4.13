<?php

// Init
error_reporting(null);
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check token
verify_csrf($_GET);

// Prevent editing of default package
if ($_GET['package'] === 'default') {
    header("Location: /list/package/");
    exit;
}

if ($_SESSION['userContext'] === 'admin') {
    if (!empty($_GET['package'])) {
        $v_package = escapeshellarg($_GET['package']);
        exec(HESTIA_CMD."v-delete-user-package ".$v_package, $output, $return_var);
    }
    check_return_code($return_var, $output);
    unset($output);
}

$back = $_SESSION['back'];
if (!empty($back)) {
    header("Location: ".$back);
    exit;
}

header("Location: /list/package/");
exit;
