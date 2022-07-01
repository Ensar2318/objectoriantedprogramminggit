<?php 
require_once 'admin/netting/class.crud.php';
$db=new crud();

// 1. Kullanım.
$sql=$db->read("settings");
$row = $sql->fetchAll(PDO::FETCH_ASSOC);
// 2. Kullanım.
// $sql=$db->qSql("SELECT * FROM settings");
// $row = $sql->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// echo print_r($row);
foreach ($row as $key => $val) {
    $settings[$val['settings_key']]=$val;
}


?>