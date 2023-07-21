<?php
session_start();
require_once 'php/User.php';

User::logout();
header("Location: php/login.php");
exit();
?>
