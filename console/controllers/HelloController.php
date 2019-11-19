<?php
namespace console\controllers;
use yii\console\Controller;
use common\models\Post;

class HelloController extends Controller
{
    public $rev;
    public function options($actionID)
    {

        return ['rev'];
    }
    public function actionIndex()
   {
       if($this->rev==1)
       {
           echo strrev("Hell0 World!\n");
       }
       else
       {
           var_dump($this->rev);
           echo "Hello World \n";
       }
   }



    public function actionList()
   {
       $posts=Post::find()->all();
       foreach($posts as $apost)
       {
         echo $apost['id'].'-'.$apost['title']."\n";
       }
   }

   public function actionWho($name)
   {
       echo ("Hello".$name."!\n");
   }

   public function actionAll(array $names)
   {
       var_dump($names);

   }
}
?>