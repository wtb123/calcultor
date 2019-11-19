<?php
use yii\helpers\Html;
?>
<div class="post">
    <div class="title">
        <h2><a href="<?=$model->url?>"><?= Html::encode($model->title)?></a></h2>

        <div class="auth">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp"?></em>
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            <em><?= $model->author->nickname?></em>
        </div>
        <br>

        <div class="content">
            <?= $model->beginning?>
        </div>
            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
            <?= implode('.',$model->tagLinks);?>
            <br>
            <?=Html::a("评论 ({$model->commentCount})",$model->url.'#comments')?> | 最后修改于 <?=date('Y-m-s H:i:s',$model->update_time)?>
        <br>
    </div>
</div>
