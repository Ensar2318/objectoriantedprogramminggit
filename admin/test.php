<?php 
$_POST=[
    "ad"=>"melih",
    "soyad"=>"mehmet",
    "no"=>"51"
];

echo print_r($_POST);

$_POST['ad']="salih";
echo print_r($_POST);

// echo implode(",",array_map(function($item){
//     return $item."=?";
// },array_keys($_POST)));



?>