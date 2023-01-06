<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;



/* This code is for test purposes
var_dump($loggedIn);
var_dump($userId[0]["siteuserId"]);
var_dump($username);
 * 
 */

?>



<?php if($loggedIn){?>
 
 

<?= Html::a('Create Ad', ['create'], ['style'=>'color:green;font-size:20px;'])."<br><br>"; } ?>

<?php if($username == 'admin'){?>

<?= Html::a('Upload an image', ['upload'], ['style'=>'color:green;font-size:20px;']);   ?>

<?php } else { echo "";}?>


<h1>Ads</h1>

<table class="table table-hover">
  <tr>
   <th>image</th>
    <th>title</th>
    <th>description</th>
    <th>author name</th>
    <th>created_at datetime</th>
    <th></th>
    <th></th>
  </tr>
  
<?php foreach ($announcements as $announcement): ?>
  <?php 
   //This code is for test purposes
  //var_dump($announcement->siteuserId);
   //var_dump($userId[0]);
   //exit;
  ?>
   
    <tr>
     <td><?php foreach ($images as $image): ?>
     <?php if($announcement->imageId == $image->id){ ?>
     <?= Html::a(Html::img($image->imagePath, ['alt' => $announcement->announcementTitle, 'style'=>'width:250px;']), ['show', 'announcementId'=>$announcement->announcementId], ['style'=>'color:green;font-size:20px;', 'target'=>'_blank']); ?>
     <?php }; ?>
     <?php endforeach; ?></td>
     <td><?= Html::a($announcement->announcementTitle, ['show', 'announcementId'=>$announcement->announcementId], ['style'=>'color:green;font-size:20px;']); ?></td>
     <td><?= $announcement->announcementDescription ?></td>
     <td><?= $announcement->announcementAuthorName ?></td>
     <td><?= $announcement->announcementCreationDate ?></td>  
     <?php if (isset($userId)) {?>
     <?php if ($userId[0]["siteuserId"] === $announcement->siteuserId) {?>
     <td><button style="width:100px;height:35px;background-color:red;"><?= Html::a('Delete', ['delete', 'announcementId'=>$announcement->announcementId], ['style'=>'text-decoration:none;color:white;']) ?></button></td> 
     <td><button style="width:100px;height:35px;background-color:blue;"><?= Html::a('Edit', ['edit', 'announcementId'=>$announcement->announcementId], ['style'=>'text-decoration:none;color:white;']) ?></button></td>
     <?php } ?>
     <?php } ?>
  </tr>
<?php endforeach; ?>
</table>


<?= LinkPager::widget(['pagination' => $pagination]) ?>

