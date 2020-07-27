<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* This code is for test purposes
var_dump($post);
var_dump($loggedIn);
var_dump((int)$userId[0]["siteuserId"]);
var_dump($username);
echo date('Y-m-d')." ".date('h:i:s');
*/

?>
<div class="site-login">
 
 <?php if($loggedIn){?>
 
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Now you can update the ad:</p>
    
    <h1><?php echo $message; ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'title')->textInput(['value'=> $announcement->announcementTitle, 'autofocus' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['value'=> $announcement->announcementDescription, 'rows' => 5]) ?>
    
        <?= $form->field($model, 'author')->hiddenInput(['value'=> $username])->label(false);?>
    
        <?= $form->field($model, 'datetime')->hiddenInput(['value'=> $announcement->announcementCreationDate])->label(false);?>
    
        <?= $form->field($model, 'siteuserId')->hiddenInput(['value'=> (int)$userId[0]["siteuserId"]])->label(false);?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Save', ['update', 'announcementId'=>$announcement->announcementId, 'class' => 'btn btn-primary']); ?>
            </div>
        </div>
    
    <?php ActiveForm::end(); ?>
    
<?php } ?>
    
<?php if(!$loggedIn){
 
 $this->goHome();
 
}?>


