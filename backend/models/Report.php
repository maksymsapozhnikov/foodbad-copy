<?php

namespace backend\models;

use common\models\ClickThrough;
use common\models\CuisineTypes;
use common\models\CuisineTypesAssn;
use common\models\Delivery;
use common\models\Platform;
use common\models\Restaurant;
use common\models\Suburb;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class Report extends Platform
{
    public $startDate;
    public $endDate;
    public $deliveryServiceIds;
    public $restaurantIds;
    public $suburbIds;
    public $cuisineIds;

    public $deliveryServicesList = [];
    public $suburbsList = [];
    public $restaurantsList = [];
    public $cuisinesList = [];

    const AVERAGE_ORDER = 30;
    const SERVICE_COST  = 50;

    public function init()
    {
        $this->deliveryServicesList = $this->servicesList();
        $this->suburbsList = $this->suburbsList();
        $this->cuisinesList = $this->cuisinesList();
        parent::init();
    }

    public function rules()
    {
        return [
           [['deliveryServiceIds'], 'required'],
           [['startDate', 'endDate', 'deliveryServiceIds', 'restaurantIds', 'suburbIds', 'cuisineIds'], 'safe']
        ];
    }

    public function formName()
    {
        return '';
    }

    public function attributeLabels()
    {
        return [
           'deliveryServiceIds' => 'Delivery Services',
           'restaurantIds' => 'Restaurants',
           'suburbIds' => 'Suburbs',
           'cuisineIds' => 'Cuisines'
        ];
    }

    public function search($params)
    {
        $query = static::find()->groupBy(Platform::tableName() . '.id')->groupBy(Platform::tableName() . '.id');
        $query->select([Platform::tableName() . '.*', 'through' => 'SUM(click_through.quantity)']);
        $query->joinWith('deliveries.clickThroughs', false);

        $this->load($params);

        /* Services */

        if (!$this->deliveryServiceIds) {
            $this->deliveryServiceIds = array_keys($this->deliveryServicesList);
        }

        $query->andWhere(['IN', Platform::tableName() . '.id', $this->deliveryServiceIds]);

        /* Time Period */

        if (!$this->startDate || !$this->endDate) {
            $this->startDate = date('d-m-Y', strtotime('today'));
            $this->endDate = $this->startDate;
        }

        $query->andWhere(['>=', ClickThrough::tableName() . '.created_at', strtotime($this->startDate)]);
        $query->andWhere(['<=', ClickThrough::tableName() . '.created_at', strtotime($this->endDate) + (60 * 60 * 24)]);

        /* Restaurants */
        /* Suburbs || Cuisines */

        if (!empty($this->restaurantIds)) {
            $query->joinWith('deliveries.restaurants', false);
            $query->andWhere(['IN', Restaurant::tableName() . '.id', $this->restaurantIds]);
            $this->restaurantsList = Restaurant::find()->select('title')->where(['IN', 'id', $this->restaurantIds])->indexBy('id')->column();
        }elseif (!empty($this->suburbIds) || !empty($this->cuisineIds)) {
            if ($this->suburbIds) {
                $query->andWhere(['IN', Delivery::tableName() . '.suburb_id', $this->suburbIds]);
            }
            if ($this->cuisineIds) {
                $query->joinWith('deliveries.restaurantCuisineTypesAssn.tagsInCategory', false);
                $query->andWhere(['IN', CuisineTypesAssn::tableName() . '.type_id', $this->cuisineIds]);
            }
        }

        return new ArrayDataProvider(
           [
              'allModels' => $query->asArray()->all(),
           ]
        );
    }


    protected function servicesList(): array
    {
        return Platform::find()->select('title')->indexBy('id')->column();
    }

    protected function suburbsList(): array
    {
        return Suburb::find()->select('title')->where(['is_state' => Suburb::IS_SUBURB])->orderBy(['title' => SORT_ASC])->indexBy('id')->column();
    }

    protected function cuisinesList(): array
    {
        return CuisineTypes::find()->select('title')->where(['category' => CuisineTypes::CATEGORY_MAIN])->orderBy(['title' => SORT_ASC])->indexBy('id')->column();
    }

    public function arrayToString($array, $explode = ', ')
    {
        $string = '';
        if (!empty($array)) {
            foreach ($array as $item) {
                $string .= $item . $explode;
            }
        }
        return rtrim($string, $explode);
    }

}