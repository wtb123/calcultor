<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin([
        'action' =>['post/detail','id'=>$id,'#'=>'comment'],
        'method'=>'post',
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <?=$form->field($recentComments,'content')
            ->textarea(['row'=>4]);?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($recentComments->isNewRecord?'发布':'修改', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
