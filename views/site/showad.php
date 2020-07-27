<?php

use yii\helpers\Html;

/* This code is for test purposes
var_dump($loggedIn);
var_dump((int)$userId[0]["siteuserId"]);
var_dump($username);
*/

?>
<div class="site-login">
 
 <h1><?php echo $message; ?></h1>
 
 <ul>
  
  <li><b>title:</b>&nbsp;&nbsp;<?= $announcement->announcementTitle ?></li>
  
  <li><b>description:</b>&nbsp;&nbsp;<?= $announcement->announcementDescription ?></li>
  
  <li><b>author name:</b>&nbsp;&nbsp;<?= $announcement->announcementAuthorName ?></li>
  
  <li><b>creation date:</b>&nbsp;&nbsp;<?= $announcement->announcementCreationDate ?></li>
  
 </ul>
 
 <?php if ($loggedIn && (int)$userId[0]["siteuserId"]==$announcement->siteuserId){?>
 
 <?= Html::a('Delete', ['delete', 'announcementId'=>$announcement->announcementId], ['class'=>'label label-danger']) ?>
 
<?php } ?> 
