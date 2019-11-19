<?php

namespace backend\controllers;

use function foo\func;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'httpCache'=>[
                'class'=>'yii\filters\HttpCache',
                'only'=>['detail'],
                'lastModified'=>function($action,$params)
                {
                    $q=new \yii\db\Query();
                    return $q->from('post')->max('update_time');
                },
                'etagSeed'=>function($action,$params)
                {
                    $post=$this->findModel(Yii::$app->request->get('id'));
                    return serialize([$post->title,$post->countent]);
                },
                'cacheControlHeader'=>'public,max-age=600',
            ],
       /*   'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                  [
                      'actions'=>['index','view'],
                      'allow'=>true,
                      'roles'=>['?'],
                  ],
                    [
                        'actions'=>['index','view','create','update'],
                        'allow'=>true,
                        'roles'=>['@'],
                    ],
                ],
            ], */
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*echo "<pre>";
        $allStatus=Post::find()->asArray();
        var_dump($allStatus);
        exit(0);*/
        $searchModel = new PostSearch();//PostSearch extends Post
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //echo "<pre>";
        //print_r($dataProvider);
        //exit(0);
        //PostSearch 类的 Search方法返回 $dataProvider数据提供者
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view',[
            'model'=>$this->findModel($id)
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(!Yii::$app->user->can('createPost'))
        {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限.');
        }
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('updatePost'))
        {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限.');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('deletePost'))
        {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限.');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
