<?php
$db = new crud();
if (!isset($_SESSION['admins']) && isset($_COOKIE['adminsLogin'])) {
    $adminLogin = json_decode($_COOKIE['adminsLogin']);

    $sonuc = $db->adminsLogin($adminLogin->admins_username,$adminLogin->admins_pass,TRUE);
    if(!$sonuc['status']){
        header("Location:login.php");
    }
}


if (!isset($_SESSION['admins']) && !isset($_COOKIE['adminsLogin'])) {
    header("Location:login.php");
}
