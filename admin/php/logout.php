<?php
session_start();
unset($_SESSION['admin_system']);
header('location: ../index.php');
exit();
?>