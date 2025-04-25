<?php
require_once 'includes/config.php';

session_unset();
session_destroy();

$_SESSION['success_message'] = 'You have been logged out successfully.';
header("Location: index.php");
exit();
?>