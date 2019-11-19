<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content
 * @property int $status
 * @property int $create_time
 * @property int $userId
 * @property string $email
 * @property string $url
 * @property int $post_id
 * @property int $remind
 *
 * @property User $user
 * @property Commentstatus $status0
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['status', 'create_time', 'userId', 'post_id','remind'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Commentstatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'status' => '状态',
            'create_time' => '评论时间',
            'userId' => '评论用户ID',
            'email' => '邮箱',
            'url' => 'Url',
            'post_id' => '评论文章ID',
            'remind' => '是否提醒',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getBeginning()
    {
        $tmpStr=strip_tags($this->content);
        $tmpLen=mb_strlen($tmpStr);
        return mb_substr($tmpStr,0,20,'utf-8').(($tmpLen>20)?'...':'');
    }

    /**
     * @return bool
     * 审核功能
     */
    public function approve()
    {
      $this->status=2; //设置状态为已经审核
        return ($this->save())?true:false;
    }

    /**
     * @return mixed
     *
     */
    public static function getPengdingCommentCount()
    {
        return Comment::find()->where(['status'=>1])->count();
    }

    public static function findRecentComments($limit=10)
    {
        return Comment::find()->where(['status'=>2])->orderBy('create_time DESC')
            ->limit($limit)->all();
    }
}
