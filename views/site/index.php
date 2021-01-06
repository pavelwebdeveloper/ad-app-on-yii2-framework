<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

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
<div class="site-login">
 
 <?php if(!$loggedIn){?>
 
    <p>Please fill out the following fields to login or sign up:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login or Signup', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    
</div>
 <?php } ?>
<?php if($loggedIn){?>
 
 

<?= Html::a('Create Ad', ['create'], ['style'=>'color:green;font-size:20px;'])."<br><br>"; } ?>

<?php if($username == 'admin'){?>

<?= Html::a('Upload an image', ['upload'], ['style'=>'color:green;font-size:20px;']);   ?>

<?php } else { echo "";}?>


<h1>Ads</h1>
<div style="overflow-x:auto;">
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
  /* This code is for test purposes
  var_dump($announcement->siteuserId);
   */
  ?>
   
    <tr>
     <td><?php foreach ($images as $image): ?>
     <?php if($announcement->imageId == $image->id){ ?>
     <?= Html::img($image->imagePath, ['alt' => $announcement->announcementTitle, 'style'=>'width:250px;']); ?>
     <?php }; ?>
     <?php endforeach; ?></td>
     <td><?= Html::a($announcement->announcementTitle, ['show', 'announcementId'=>$announcement->announcementId], ['style'=>'color:green;font-size:20px;']); ?></td>
     <td><?= $announcement->announcementDescription ?></td>
     <td><?= $announcement->announcementAuthorName ?></td>
     <td><?= $announcement->announcementCreationDate ?></td>    
     <?php if ($userId[0]["siteuserId"] === $announcement->siteuserId) {?>
     <td><button style="width:100px;height:35px;background-color:red;"><?= Html::a('Delete', ['delete', 'announcementId'=>$announcement->announcementId], ['style'=>'text-decoration:none;color:white;']) ?></button></td> 
     <td><button style="width:100px;height:35px;background-color:blue;"><?= Html::a('Edit', ['edit', 'announcementId'=>$announcement->announcementId], ['style'=>'text-decoration:none;color:white;']) ?></button></td>
     <?php } ?>
  </tr>
<?php endforeach; ?>
</table>
 <div>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
