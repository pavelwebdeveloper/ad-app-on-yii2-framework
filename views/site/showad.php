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
 
 <div class="car-post-row">
 <div class="post-item title-font post-item">
     <?= $announcement->announcementTitle ?>
 </div>
 <div class="post-item">  
 <?= Html::img($image, ['alt' => $announcement->announcementTitle, 'style'=>'width:250px;']) ?>  
 </div>
</div>
 
 <div class="car-post-row">
     <div class="description-block-size post-item">
         <h2>
             Description
         </h2>
         <div class="discription-text">
         <?= $announcement->announcementDescription ?>
         </div>
     </div>
     <div class="post-item">
         <h2>
             Technical characteristics
         </h2>
         <ul> 
  
            <li><b>Engine:</b>&nbsp;&nbsp;<?= $announcement->engine ?></li>

            <li><b>Top speed:</b>&nbsp;&nbsp;<?= $announcement->topSpeed ?></li>
  
        </ul>
     </div>
  </div>
 

 </div>
  
 <?php if ($loggedIn && (int)$userId[0]["siteuserId"]==$announcement->siteuserId){?>
 
 <?= Html::a('Delete', ['delete', 'announcementId'=>$announcement->announcementId], ['class'=>'label label-danger']) ?>
 
<?php } ?> 
