<?php 
require_once 'settings.php';
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
    <h1>Selamlar hoşgeldiniz</h1>
 <?php if ($settings['facebook']['settings_status']) { ?>
    <h3>facebook adreslerimiz : <?php echo $settings['facebook']['settings_value'] ?></h3>
 <?php }?>
 </body>
 </html>