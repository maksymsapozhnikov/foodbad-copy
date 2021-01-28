<?php

namespace frontend\services;

use common\models\CuisineTypes;
use common\models\Delivery;
use common\models\FavoriteAssn;
use common\models\Restaurant;
use common\models\Suburb;
use yii\helpers\ArrayHelper;

class Services
{

    /**
     * @return array|mixed
     */
    public static function cuisineTypes()
    {
        /*$cuisineTypes = \Yii::$app->cache->get('cuisine-types');
        if ($cuisineTypes) {
            return $cuisineTypes;
        }*/

        $cuisineTypes = CuisineTypes::find()->select('title,id,image')->where([
           'category' => CuisineTypes::CATEGORY_MAIN,
           'status' => CuisineTypes::STATUS_ACTIVE
        ])->orderBy(['id' => SORT_ASC])->all();

        if ($cuisineTypes) {
            //\Yii::$app->cache->set('cuisine-types', $cuisineTypes, 3600 * 24);
            return $cuisineTypes;
        }
        return [];
    }

    /**
     * @param null|string $string
     * @return array
     */
    public static function suburbsList($string = null)
    {
        $out = [];
        $query = Suburb::find()->select([Suburb::tableName() . '.*', 'state_title' => 'state.title'])->leftJoin(Suburb::tableName() . ' AS state', 'state.id = suburb.state_id')->where([Suburb::tableName() . '.is_state' => Suburb::IS_SUBURB])->orderBy([Suburb::tableName() . '.title' => SORT_ASC]);

        if (!empty($string)) {
            $string = trim(strip_tags($string));
            $query->where(['LIKE', Suburb::tableName() . '.title', $string]);
        }

        $array = $query->limit(20)->asArray()->all();
        foreach ($array as $item) {
            $out['results'][] = [
               'id' => $item['id'],
               'text' => (!empty($item['state_title'])) ? $item['title'] . ', ' . $item['state_title'] : $item['title']
            ];
        }
        return $out;
    }

    /**
     * @return string
     */
    public static function suburbTitle()
    {
        $data = Suburb::find()->where(['id' => \Yii::$app->user->identity->suburb_id])->with('state')->one();
        if ($data != null) {
            $state = !empty($data->state->title) ? ', ' . $data->state->title : '';
            return $data->title . $state;
        }
        return '';
    }

    /**
     * @param $data string
     * @return bool
     */
    public static function setFavorites($data)
    {
        if ($data) {
            $model = FavoriteAssn::find()->where([
               'user_id' => \Yii::$app->user->identity->id,
               'restaurant_id' => (int)$data,
            ])->limit(1)->one();
            if ($model != null) {
                $model->delete();
                return 'remove';
            }else {
                $model = new FavoriteAssn();
                $model->setAttributes([
                   'user_id' => \Yii::$app->user->identity->id,
                   'restaurant_id' => (int)$data,
                ]);
                if ($model->save()) {
                    return 'add';
                }
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getFavorites()
    {
        return FavoriteAssn::find()->select('restaurant_id')->where([
           'user_id' => \Yii::$app->user->identity->id,
        ])->column();
    }

    public static function checkSuburb($post)
    {
        $name = !empty($post['n']) ? ucfirst(strtolower(trim(strip_tags($post['n'])))) : null;
        $state = !empty($post['s']) ? strtoupper(trim(strip_tags($post['s']))) : null;
        if ($name && $state) {
            $model = Suburb::find()->select(['s_id' => 'suburb.id'/*, 'restaurant.id'*/])->where([
               Suburb::tableName() . '.title' => $name,
               Suburb::tableName() . '.is_state' => Suburb::IS_SUBURB,
               'state.title' => $state
            ])->leftJoin(Suburb::tableName() . ' as state', 'state.id = suburb.state_id')->leftJoin(Delivery::tableName(), Delivery::tableName() . '.suburb_id = suburb.id')->andWhere(['IS NOT', Delivery::tableName() . '.id', null])->andWhere(['>', Delivery::tableName() . '.delivery_fee', 0])->andWhere(['IS NOT', Delivery::tableName() . '.average_delivery_time', null])->asArray()->one();
            if ($model !== null) {
                return ['suburb_id' => $model['s_id']];
            }
        }
        return 0;
    }

    public static function cuisineTitle($category)
    {
        if ($category) {
            switch ($category) {
                case 'all' :
                    return 'All cuisines';
                    break;
                case 'favourites' :
                    return 'Favourites';
                    break;
                case 'filtered' :
                    return 'Filtered';
                    break;
            }
            $cuisine = CuisineTypes::find()->where([
               'id' => (int)$category,
               'category' => CuisineTypes::CATEGORY_MAIN,
               'status' => CuisineTypes::STATUS_ACTIVE
            ])->one();
            if ($cuisine !== null) {
                return $cuisine->title;
            }
        }
        return 'All cuisines';
    }

}