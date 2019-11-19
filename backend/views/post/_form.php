<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststaus;
use common\models\Post;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    /*
    $psObjs=Poststaus::find()->all();
    $allStatus=\yii\helpers\ArrayHelper::map($psObjs,'id','name');
    */
    ?>

    <?php
    $allModel=Poststaus::find()->all();
    $allStatus=\yii\helpers\ArrayHelper::map($allModel,'id','name');
    ?>
    <?= $form->field($model,'status')
        ->dropDownList($allStatus,['prompt'=>'请选择状态']);?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
