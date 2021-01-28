<?php

namespace backend\models\search;

use common\models\CuisineTypesAssn;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CuisineTypes;

/**
 * CuisineTypesSearch represents the model behind the search form of `common\models\CuisineTypes`.
 */
class CuisineTypesSearch extends CuisineTypes
{
    public $tags;

    public function rules()
    {
        return [
            [['id', 'status', 'category','tags'], 'integer'],
            [['code_api', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = CuisineTypes::find()->groupBy(self::tableName() . '.id');
        $query->joinWith(['cuisineTypesAssn' => function($q){
            $q->select('cuisine_types_assn.*,t.title')->leftJoin(CuisineTypes::tableName() . ' AS t','t.id = {{cuisine_types_assn}}.tag_id')->asArray();
        }]);
        $query->andWhere([self::tableName() . '.category' => self::CATEGORY_MAIN]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
           self::tableName() . '.id' => $this->id,
           self::tableName() . '.status' => $this->status,
           CuisineTypesAssn::tableName() . '.tag_id' => $this->tags,
         ]);

        $query->andFilterWhere(['like', 'code_api', $this->code_api])
            ->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        return $dataProvider;
    }
}
