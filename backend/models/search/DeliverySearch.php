<?php

namespace backend\models\search;

use common\models\Delivery;
use common\models\Suburb;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Restaurant;

/**
 * RestaurantSearch represents the model behind the search form of `common\models\Delivery`.
 */
class DeliverySearch extends Delivery
{
    public $suburbTitle;

    public function rules()
    {
        return [
            [['id', 'platform_id', 'state_id', 'suburb_id', 'average_delivery_time', 'status', 'restaurant_suburb', 'created_at', 'updated_at'], 'integer'],
            [['title', 'delivery_time', 'image_link', 'image', 'link', 'clean_link', 'pre_order_times', 'cuisine','suburbTitle'], 'safe'],
            [['rating', 'delivery_fee'], 'number'],
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
        $query = Delivery::find()->groupBy(self::tableName() . '.id');
        $query->joinWith('platform',false);
        $query->joinWith('suburb');

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
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.platform_id' => $this->platform_id,
            self::tableName() . '.state_id' => $this->state_id,
            self::tableName() . '.suburb_id' => $this->suburb_id,
            self::tableName() . '.rating' => $this->rating,
            self::tableName() . '.delivery_fee' => $this->delivery_fee,
            self::tableName() . '.average_delivery_time' => $this->average_delivery_time,
            self::tableName() . '.status' => $this->status,
            self::tableName() . '.restaurant_suburb' => $this->restaurant_suburb,
            self::tableName() . '.created_at' => $this->created_at,
            self::tableName() . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', self::tableName() . '.delivery_time', $this->delivery_time])
            ->andFilterWhere(['like', self::tableName() . '.image_link', $this->image_link])
            ->andFilterWhere(['like', self::tableName() . '.image', $this->image])
            ->andFilterWhere(['like', self::tableName() . '.link', $this->link])
            ->andFilterWhere(['like', self::tableName() . '.clean_link', $this->clean_link])
            ->andFilterWhere(['like', self::tableName() . '.pre_order_times', $this->pre_order_times])
            ->andFilterWhere(['like', self::tableName() . '.cuisine', $this->cuisine])
            ->andFilterWhere(['like', Suburb::tableName() . '.title', $this->suburbTitle]);

        return $dataProvider;
    }
}
