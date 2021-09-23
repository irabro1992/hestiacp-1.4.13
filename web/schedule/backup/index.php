<?php

// Init
error_reporting(null);
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check token
verify_csrf($_GET);

$v_username = escapeshellarg($user);
exec(HESTIA_CMD."v-schedule-user-backup ".$v_username, $output, $return_var);
if ($return_var == 0) {
    $_SESSION['error_msg'] = _('BACKUP_SCHEDULED');
} else {
    $_SESSION['error_msg'] = implode('<br>', $output);
    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = _('Error: Hestia did not return any output.');
    }

    if ($return_var == 4) {
        $_SESSION['error_msg'] = _('BACKUP_EXISTS');
    }
}
unset($output);
header("Location: /list/backup/");
exit;
