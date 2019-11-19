<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\Adminuser;

/**
 * PostSearch represents the model behind the search form of `common\models\Post`.
 */
class PostSearch extends Post
{
    public function attributes()
    {
        return array_merge(parent::attributes(),['authorName']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags','authorName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>5],
            'sort'=>[
              'defaultOrder'=>[
                  'id'=>SORT_DESC,
              ] ,
            //    'attributes'=>['id','title'],
            ],
        ]);

        $this->load($params);

        /**
         * 如果输入的查询文字不符合验证规则，可以选择不展示或者展示全部数据
         */
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //$query仍作用于$dataProvider
        // grid filtering conditions
        $query->andFilterWhere([
            'post.id' => $this->id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

      $query->join('INNER JOIN','adminuser','post.author_id=adminuser.id');
      $query->andFilterWhere(['like','adminuser.nickname',$this->authorName]);

        $dataProvider->sort->attributes['authorName']=[
          'asc'=>['adminuser.nickname'=>SORT_ASC],
          'desc'=>['adminuser.nickname'=>SORT_DESC],
        ];
      /*  echo $query ->createCommand()->getRawSql();
        exit(0);*/
        return $dataProvider;
    }
}
