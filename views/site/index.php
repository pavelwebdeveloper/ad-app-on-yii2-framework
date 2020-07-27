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

    <div class="col-lg-offset-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div>
</div>
 <?php } ?>
<?php if($loggedIn){?>
 
 
<?= Html::a('Create Ad', ['create']);  }; ?>


<h1>Ads</h1>
<table class="table table-hover">
  <tr>
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
     <td><?= Html::a($announcement->announcementTitle, ['show', 'announcementId'=>$announcement->announcementId]); ?></td>
     <td><?= $announcement->announcementDescription ?></td>
     <td><?= $announcement->announcementAuthorName ?></td>
     <td><?= $announcement->announcementCreationDate ?></td>    
     <?php if ($userId[0]["siteuserId"] === $announcement->siteuserId) {?>
     <td><?= Html::a('Delete', ['delete', 'announcementId'=>$announcement->announcementId], ['class'=>'label label-danger']) ?></td> 
     <td><?= Html::a('Edit', ['edit', 'announcementId'=>$announcement->announcementId], ['class'=>'label label-primary']) ?></td>
     <?php } ?>
  </tr>
<?php endforeach; ?>
</table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
