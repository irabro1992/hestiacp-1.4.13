<?php

// Init
error_reporting(null);
ob_start();
session_start();

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check user
if ($_SESSION['userContext'] != 'admin') {
    header("Location: /list/user");
    exit;
}

// Check token
verify_csrf($_GET);

if ((!empty($_GET['ip'])) && (!empty($_GET['chain']))) {
    $v_ip = escapeshellarg($_GET['ip']);
    $v_chain = escapeshellarg($_GET['chain']);
    exec(HESTIA_CMD."v-delete-firewall-ban ".$v_ip." ".$v_chain, $output, $return_var);
}
check_return_code($return_var, $output);
unset($output);

$back = $_SESSION['back'];
if (!empty($back)) {
    header("Location: ".$back);
    exit;
}

header("Location: /list/firewall/banlist/");
exit;
