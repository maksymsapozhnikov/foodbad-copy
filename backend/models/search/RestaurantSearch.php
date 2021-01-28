<?php

namespace backend\models\search;

use common\models\ClickThrough;
use common\models\CuisineTypes;
use common\models\Platform;
use common\models\Suburb;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Restaurant;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * RestaurantSearch represents the model behind the search form of `common\models\Restaurant`.
 */
class RestaurantSearch extends Restaurant
{
    public $suburbTitle;
    public $startDate;
    public $endDate;
    public $date;

    public function rules()
    {
        return [
            [['id', 'platform_id', 'state_id', 'suburb_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image','suburbTitle','startDate','endDate','date'], 'safe'],
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
        $query = self::find()->groupBy(Restaurant::tableName() . '.id');
        $query->joinWith('suburb');
        $query->joinWith('state');
        $query->with(['deliveries.restaurantCuisineTypesAssn' => function(ActiveQuery $q){
            $q->select('restaurant_cuisine_types_assn.*,cuisine_types.title');
            $q->asArray();
            $q->leftJoin(CuisineTypes::tableName(),'cuisine_types.id = restaurant_cuisine_types_assn.cuisine_type_id');
        }]);
        $query->with(['deliveries.clickThroughs' => function(ActiveQuery $q){
            if(!empty($this->endDate && $this->startDate)){
                $end = strtotime($this->endDate) + (3600*24);
                $q->andWhere((['between',ClickThrough::tableName() . '.created_at' , strtotime($this->startDate), $end]));
            }
            $q->asArray();
        }]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            Restaurant::tableName() . '.id' => $this->id,
            Restaurant::tableName() . '.platform_id' => $this->platform_id,
            Restaurant::tableName() . '.state_id' => $this->state_id,
            Restaurant::tableName() . '.suburb_id' => $this->suburb_id,
            Restaurant::tableName() . '.status' => $this->status,
            Restaurant::tableName() . '.created_at' => $this->created_at,
            Restaurant::tableName() . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', Restaurant::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', Suburb::tableName() . '.title', $this->suburbTitle]);

        return $dataProvider;
    }
}
