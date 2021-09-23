<?php

// Init
error_reporting(null);
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check token
verify_csrf($_GET);

if (!empty($_GET['database'])) {
    $v_username = escapeshellarg($user);
    $v_database = escapeshellarg($_GET['database']);
    exec(HESTIA_CMD."v-suspend-database ".$v_username." ".$v_database, $output, $return_var);
    check_return_code($return_var, $output);
    unset($output);
}

$back = $_SESSION['back'];
if (!empty($back)) {
    header("Location: ".$back);
    exit;
}

header("Location: /list/db/");
exit;
