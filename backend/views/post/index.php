<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststaus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php //$searchModel=new common\models\Comment();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
           //'author_id',
            ['attribute'=>'authorName',
             'label'=>'作者',
             'value'=>'author.nickname',
            ],
           // 'content:ntext',
            'tags:ntext',
           // 'status',
            ['attribute'=>'status',
                'value'=>'status0.name',
                'filter'=>Poststaus::find()
                ->select(['name','id'])
                ->orderBy('position')
                ->indexBy('id')
                ->column(),
            ],
            //'create_time:datetime',
            'update_time:datetime',
            //'author_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
