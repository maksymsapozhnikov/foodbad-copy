<?php

namespace frontend\services;

use common\models\CuisineTypes;
use common\models\Delivery;
use common\models\Restaurant;

class SearchCuisineAndRestaurants
{
    const LIMIT = 10;
    protected $responseData = [];
    protected $requestedString;


    // ['results' => ['id' => '', 'text' => '']];
    public function search($string)
    {
        $this->requestedString = $string;
        $this->cuisines();
        $this->tags();
        $this->restaurants();

        if (!empty($this->responseData)) {
            return ['results' => $this->responseData];
        }
        return ['results' => ['id' => '', 'text' => '']];
    }

    protected function cuisines()
    {
        $data = CuisineTypes::find()->select('id, title as text')->where(['like', 'title', $this->requestedString])->andWhere([
              'status' => CuisineTypes::STATUS_ACTIVE,
              'category' => CuisineTypes::CATEGORY_MAIN
           ])->asArray()->all();

        if ($data != []) {
            $this->buildArray($data, 'c');
        }
    }

    protected function tags()
    {
        $count = count($this->responseData);
        if ($count >= self::LIMIT) {
            return true;
        }
        $limit = self::LIMIT - $count;
        $data = CuisineTypes::find()->select('id, title as text')->where(['like', 'title', $this->requestedString])->andWhere([
              'status' => CuisineTypes::STATUS_ACTIVE,
              'category' => CuisineTypes::CATEGORY_TAG
           ])->asArray()->limit($limit)->all();

        if ($data != []) {
            $this->buildArray($data, 't');
        }
    }

    protected function restaurants()
    {
        $count = count($this->responseData);
        if ($count >= self::LIMIT) {
            return true;
        }
        $limit = self::LIMIT - $count;
        $data = Restaurant::find()->joinWith('deliveries', false)
           ->select([Restaurant::tableName() . '.id', 'text' => Restaurant::tableName() . '.title'])
           ->where(['like',  Restaurant::tableName() . '.title', $this->requestedString])
           ->andWhere([
              Restaurant::tableName() . '.status' => Restaurant::STATUS_ACTIVE,
              Restaurant::tableName() . '.suburb_id' => \Yii::$app->user->identity->suburb_id
           ])->andWhere(['>', Delivery::tableName() . '.delivery_fee', 0])
            ->andWhere(['NOT', [Delivery::tableName() . '.average_delivery_time' => null]])
            ->andWhere([Delivery::tableName() . '.status' => Delivery::STATUS_ACTIVE])
            ->limit($limit)->asArray()->all();
        if ($data != []) {
            $this->buildArray($data, 'r');
        }
    }

    protected function buildArray($data, $category)
    {
        foreach ($data as $item) {
            $this->responseData[] = ['id' => $category . '_' . $item['id'], 'text' => $item['text']];
        }
    }
}