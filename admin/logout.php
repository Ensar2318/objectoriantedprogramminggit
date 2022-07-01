<?php 
session_start();
unset($_SESSION['admins']);
setcookie("adminsLogin", "", strtotime('-10 days'), "/");
header("location:login.php");
exit;
?>