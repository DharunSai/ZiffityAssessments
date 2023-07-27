<?php
session_start();
require_once 'php/User.php';

User::logout();
session_destroy();
header("Location: php/login.php");
exit();
?>
