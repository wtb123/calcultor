<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Comment;

class SmsController extends Controller
{
    public function actionSend()
    {
        $newCommentCount=Comment::find()->where(['remind'=>0,'status'=>1])->count();//查看未提醒的新评论有多少条
        if($newCommentCount>0)
        {
            $content='有'.$newCommentCount.'评论待审核。';
            $result=$this->vendorSmsService($content);
            if($result['status']='success')
            {
                Comment::updateAll(['remind'=>1]);//把提醒标志全部设为已提醒
                echo '['.date('Y-m-d H:i:s',$result['dt']).']'.$content.'['.$result['length'].']'."\r\n";
            }
            return 0;
        }
    }

    protected function vendorSmsService($content)
    {

        $result=array("status"=>"success","dt"=>time(),"length"=>43);//模拟数据
        return $result;
    }

}
