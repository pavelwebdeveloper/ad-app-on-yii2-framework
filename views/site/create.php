<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Image;

/* This code is for test purposes
var_dump($loggedIn);
var_dump((int)$userId[0]["siteuserId"]);
var_dump($username);
echo date('Y-m-d')." ".date('h:i:s');
 * 
 */

?>
<div class="site-login">
 
 <?php if($loggedIn){?>
 
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to add a new ad. Please, notice that the photos can be uploaded only by the admin user:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    
    <?php if($username == 'admin'){?>
    <?= $form->field($model, 'imageId')->dropdownList(
    Image::find()->select(['imagePath', 'id'])->indexBy('id')->column(),
    ['prompt'=>'Select Image']) ?>
    
    <?php } else {?>
    
    <?= $form->field($model, 'imageId')->hiddenInput(['value'=> '../images/rope.jpg'])->label(false); } ?>

        <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
    
        <?= $form->field($model, 'author')->hiddenInput(['value'=> $username])->label(false);?>
    
        <?= $form->field($model, 'datetime')->hiddenInput(['value'=> date('Y-m-d')." ".date('h:i:s')])->label(false);?>
    
        <?= $form->field($model, 'siteuserId')->hiddenInput(['value'=> (int)$userId[0]["siteuserId"]])->label(false);?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Create', ['create', 'class' => 'btn btn-primary']); ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
<?php } ?>
    
<?php if(!$loggedIn){
 
 $this->goHome();
 
}?>
