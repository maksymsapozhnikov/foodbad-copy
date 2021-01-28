<?php

namespace backend\models\search;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Messages;

/**
 * MessagesSearch represents the model behind the search form of `common\models\Messages`.
 */
class SupportRequestSearch extends Messages
{
    public $name;
    public $lastName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['id', 'status', 'category', 'parent_id', 'to', 'from', 'created_at', 'updated_at'], 'integer'],
           [['title', 'body','name','lastName'], 'safe'],
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
        $query = static::find();
        $query->joinWith('fromUser');
        $query->where(['category' => self::CATEGORY_SUPPORT_REQUEST]);
        $query->orderBy([self::tableName() . '.id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
           'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
           self::tableName() . '.id' => $this->id,
           self::tableName() . '.status' => $this->status,
           self::tableName() . '.category' => $this->category,
           self::tableName() . '.parent_id' => $this->parent_id,
           self::tableName() . '.to' => $this->to,
           self::tableName() . '.from' => $this->from,
           self::tableName() . '.created_at' => $this->created_at,
           self::tableName() . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
           ->andFilterWhere(['like', User::tableName() . '.userName', $this->name])
           ->andFilterWhere(['like', User::tableName() . '.lastName', $this->lastName])
           ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
