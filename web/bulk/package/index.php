<?php

// Init
error_reporting(null);
ob_start();
session_start();

include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check token
verify_csrf($_POST);

$package = $_POST['package'];
$action = $_POST['action'];

if ($_SESSION['userContext'] === 'admin') {
    switch ($action) {
        case 'delete': $cmd='v-delete-user-package';
            break;
        default: header("Location: /list/package/"); exit;
    }
} else {
    header("Location: /list/package/");
    exit;
}

foreach ($package as $value) {
    $value = escapeshellarg($value);
    exec(HESTIA_CMD.$cmd." ".$value, $output, $return_var);
    $restart = 'yes';
}


header("Location: /list/package/");
