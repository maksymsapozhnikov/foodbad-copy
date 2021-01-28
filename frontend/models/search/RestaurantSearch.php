<?php

namespace frontend\models\search;

use common\models\CuisineTypes;
use common\models\CuisineTypesAssn;
use common\models\Delivery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Restaurant;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

/**
 * RestaurantSearch represents the model behind the search form of `common\models\Restaurant`.
 */
class RestaurantSearch extends Restaurant
{
    public $sort = '';
    public $type;
    public $category;
    public $cuisineTypes = [];
    public $count;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
           [['sort', 'type', 'category'], 'string'],
           ['type', 'filter', 'filter' => 'strip_tags'],
           ['sort', 'in', 'range' => ['price', 'time', 'delivery','none']]
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params = [])
    {
        $query = static::find()->groupBy(self::tableName() . '.id');
        $query->joinWith('suburb', false);
        $query->joinWith([
           'deliveries' => function ($q) {
               $q->andWhere(['>', Delivery::tableName() . '.delivery_fee', 0]);
               $q->andWhere(['NOT', [Delivery::tableName() . '.average_delivery_time' => null]]);
               $q->andWhere([Delivery::tableName() . '.status' => Delivery::STATUS_ACTIVE]);
           }
        ]);
        $query->with('deliveries.cuisineTypes');
        $query->with('deliveries.platform');

        $query->andWhere(['>', Delivery::tableName() . '.delivery_fee', 0]);
        $query->andWhere(['NOT', [Delivery::tableName() . '.average_delivery_time' => null]]);
        $query->andWhere([Delivery::tableName() . '.status' => Delivery::STATUS_ACTIVE]);

        $query->andWhere([
           'suburb.id' => Yii::$app->user->identity->suburb_id,
           self::tableName() . '.status' => self::STATUS_ACTIVE,
        ]);

        $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => false,
           'sort' => ['defaultOrder' => ['id' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $count = clone $query;
            $this->count = $count->count();
            return $dataProvider;
        }

        if ($this->category !== 'all' && ($this->category == 'favourites' || (int)$this->category)) {
            if ($this->category == 'favourites') {
                $query->joinWith('favoriteWithUser', false);
            }else {
                $query->joinWith('deliveries.restaurantCuisineTypesAssn.tagsInCategory', false);
                $query->andWhere([CuisineTypesAssn::tableName() . '.type_id' => (int)$this->category]);
            }
        }

        switch ($this->sort) {
            case 'price' :
                $query->orderBy([Delivery::tableName() . '.delivery_fee' => SORT_ASC]);
                break;
            case 'time' :
                $query->orderBy([Delivery::tableName() . '.average_delivery_time' => SORT_ASC]);
                break;
            case 'delivery' :
                break;
            default:
                $query->orderBy([self::tableName() . '.id' => SORT_DESC]);
        }

        if (!empty($this->type) && strpos($this->type, '_')) {
            list($category, $id) = explode('_', $this->type);
            if ($category == 'c') {
                $query->joinWith('deliveries.restaurantCuisineTypesAssn.tagsInCategory', false);
                $query->andWhere([CuisineTypesAssn::tableName() . '.type_id' => (int)$id]);
            }elseif ($category == 't') {
                $query->joinWith('deliveries.restaurantCuisineTypesAssn.cuisineType', false);
                $query->andWhere([CuisineTypes::tableName() . '.id' => (int)$id]);
            }elseif ($category == 'r') {
                $query->andWhere([self::tableName() . '.id' => (int)$id]);
            }
        }
        $count = clone $query;
        $this->count = $count->count();
        return $dataProvider;
    }

    public function setSort($post)
    {
        $cookies = Yii::$app->request->cookies;
        $value = $cookies->getValue('sort', '');
        if (!empty($post['sort']) && in_array($post['sort'], ['delivery', 'time', 'price'])) {
            if ($value == $post['sort']) {
                $this->addCookie('none');
                $this->sort = '';
                return true;
            }
            $this->addCookie($post['sort']);
            $this->sort = $post['sort'];
            return true;
        }
        $this->sort = $value;
        return true;
    }

    protected function addCookie($string)
    {
        $cookie = new \yii\web\Cookie([
           'name' => 'sort',
           'value' => $string,
           'expire' => time() + (60 * 60 * 24 * 365),
        ]);
        Yii::$app->response->cookies->add($cookie);
        return true;
    }
}