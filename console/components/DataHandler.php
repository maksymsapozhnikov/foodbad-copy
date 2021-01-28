<?php
namespace console\components;

use common\models\CuisineTypes;
use common\models\Platform;
use common\models\Suburb;
use Yii;


class DataHandler
{
    protected $states = [];
    protected $platforms = [];
    protected $cuisineTypes = [];
    protected $delivery;
    protected $item;

    function __construct()
    {
        $this->stateList();
        $this->platformList();
        $this->cuisineTypesList();
    }

    /*
        $this->item:
        [01 Platform] => Uber
        [02 State] => VIC
        [03 Suburb] => Park Orchards
        [04 Restaurant] => The Coffee Club (Eastland)
        [05 Rating] => 4.8
        [06 Cuisine Types] => Modern Australian ; Cafe ; Family Meals
        [07 Delivery Fee] => 6.99
        [08 Estimate Delivery Time] => 30–40 min
        [09 Image] => https://d1ralsognjng37.cloudfront.net/a1c3bd31-1bca-4c15-9891-0d15b47b93ad
        [10 Link] => https://www.ubereats.com/au/melbourne/food-delivery/the-coffee-club-eastland/R_dFp-pkSrmHv2n8RPzctg
        [11 Restaurant Suburb] => melbourne
        [12 Clean Link] => https://www.ubereats.com/au/melbourne/food-delivery/the-coffee-club-eastland/R_dFp-pkSrmHv2n8RPzctg
        [13 Pre Order Times] =>
    */

    public function sessionParse($data)
    {
        if (!empty($data) && is_array($data)) {
            foreach ($data as $item) {
                if (!empty($item['item'])) {
                    $this->item = $item['item'];
                    $this->delivery = [];
                    if (is_array($result = $this->parseItem())) {
                        $this->setDelivery($result);
                    }else {
                        continue;
                    }
                }
            }
        }
    }

    protected function parseItem()
    {
        try{
            $this->delivery['platform_id'] = $this->setPlatform();
            $this->delivery['state_id'] = $this->setState();
            $this->delivery['suburb_id'] = $this->setSuburb($this->item['03 Suburb'], $this->delivery['state_id']);
            $this->delivery['title'] = $this->setTitle();
            $this->delivery['rating'] = $this->setRating();
            $this->delivery['delivery_fee'] = $this->setDeliveryFee();
            $this->delivery['delivery_time'] = $this->setDeliveryTime();
            $this->delivery['average_delivery_time'] = $this->setAverageDeliveryTime();
            $this->delivery['image_link'] = $this->setImageLink();
            //$this->delivery['restaurant_suburb'] = !empty($this->item['11 Restaurant Suburb']) ? $this->setSuburb($this->item['11 Restaurant Suburb'], $this->delivery['state_id']) : null;
            $this->delivery['restaurant_suburb'] = !empty($this->item['11 Restaurant Suburb']) ? (int) $this->item['11 Restaurant Suburb'] : null;
            $this->delivery['link'] = $this->setLink();
            $this->delivery['clean_link'] = $this->setCleanLink();
            $this->delivery['pre_order_times'] = $this->setPreOrderTimes();
            $this->delivery['cuisine'] = $this->setCuisine();
            $this->delivery['tags'] = $this->setCategories();
            return $this->delivery;
        }catch (\Exception $e){
            \Yii::error(\json_encode($e), 'Error');
            return false;
        }
    }

    public function setCategories()
    {
        $ids = [];
        if (!empty($this->item['06 Cuisine Types'])) {
            $string = strtolower($this->item['06 Cuisine Types']);
            // if multiple
            if (strpos($string, ';')) {
                $arr = explode(';', $string);
                if (is_array($arr)) {
                    foreach ($arr as $val) {
                        $val = $this->categoryFilter($val);
                        if (key_exists($val, $this->cuisineTypes)) {
                            $ids[] = $this->cuisineTypes[$val];
                        }else {
                            if ($id = $this->addNewCategory($val)) {
                                $ids[] = $id;
                            }
                        }
                    }
                }
                // if single
            }else {
                $title = $this->categoryFilter($string);
                if (key_exists($title, $this->cuisineTypes)) {
                    $ids[] = $this->cuisineTypes[$title];
                }else {
                    if ($id = $this->addNewCategory($title)) {
                        $ids[] = $id;
                    }
                }
            }
        }
        return $ids;
    }

    /**
     * @param $title
     * @return bool|int
     */
    protected function addNewCategory($title)
    {
        $model = new CuisineTypes();
        $model->setAttributes([
           'status' => CuisineTypes::STATUS_ACTIVE,
           'code_api' => $title,
           'title' => ucfirst($title)
        ]);
        if ($model->save()) {
            $this->cuisineTypes = $this->cuisineTypes + [$title => $model->id];
            return $model->id;
        }
        return false;
    }

    protected function setCuisine()
    {
        return strip_tags($this->item['06 Cuisine Types']);
    }

    protected function setPreOrderTimes()
    {
        return trim(strip_tags($this->item['13 Pre Order Times']));
    }

    protected function setCleanLink()
    {
        return trim(strip_tags($this->item['12 Clean Link']));
    }

    protected function setLink()
    {
        return trim(strip_tags($this->item['10 Link']));
    }

    protected function setImageLink()
    {
        return trim(strip_tags($this->item['09 Image']));
    }

    protected function setAverageDeliveryTime()
    {
        $string = $this->delivery['delivery_time'];
        if (!empty($string)) {
            # 25 - 45 || 20–30 min || 10 min || 15–25 min
            $string = str_replace(['min', ' ', '–'], ['', '', '-'], $string);
            if (strpos($string, '-')) {
                list($a, $b) = explode('-', $string);
                return floor(($a + $b) / 2);
            }elseif (gettype($string * 1) == 'integer') {
                return $string;
            }
        }
        return null;

    }

    protected function setDeliveryTime()
    {
        return strip_tags(trim($this->item['08 Estimate Delivery Time']));
    }

    protected function setDeliveryFee()
    {
        $delivery = $this->item['07 Delivery Fee'] * 1;
        return (!empty($delivery) && in_array(gettype($delivery), ['double', 'integer'])) ? $delivery : 0;
    }

    protected function setRating()
    {
        $rating = $this->item['05 Rating'] * 1;
        return (!empty($rating) && in_array(gettype($rating), ['double', 'integer']) && $rating < 7) ? $rating : 0;
    }

    protected function setTitle()
    {
        return ucfirst(strtolower(trim(strip_tags($this->item['04 Restaurant']))));
    }

    protected function setSuburb($title, $state_id)
    {
        $title = ucfirst(strtolower(trim(strip_tags($title))));
        // Search suburb
        $suburb = Suburb::find()->select('id')->where([
           'is_state' => Suburb::IS_SUBURB,
           'title' => $title,
           'state_id' => $state_id
        ])->limit(1)->one();
        if ($suburb != null) {
            return $suburb->id;
        }

        // Create suburb
        $model = new Suburb();
        $model->setAttributes([
           'is_state' => Suburb::IS_SUBURB,
           'title' => $title,
           'state_id' => (int)$state_id
        ]);
        if ($model->save()) {
            return $model->id;
        }

        throw new \Exception('Suburb not found');
    }

    protected function setState()
    {
        if (!empty($this->item['02 State']) && key_exists($this->item['02 State'], $this->states)) {
            return $this->states[$this->item['02 State']];
        }
        throw new \Exception('State not found');
    }

    protected function setPlatform()
    {
        $platform = strtolower($this->item['01 Platform']);

        /* search platform */
        if (!empty($this->item['01 Platform']) && key_exists($platform, $this->platforms)) {
            return $this->platforms[$platform];
        }

        /* create platform */
        $model = new Platform();
        $model->setAttributes([
           'code_api' => $platform,
           'title' => ucfirst($platform)
        ]);
        if ($model->save()) {
            $this->platforms = array_merge($this->platforms, [$model->code_api => $model->id]);
            return $model->id;
        }

        throw new \Exception('Error: setPlatform - ' . __FILE__ . ':' . __LINE__);
    }

    protected function setDelivery($data)
    {
        /* Update */

        $model = Delivery::find()->where([
           'title' => $data['title'],
           'state_id' => $data['state_id'],
           'platform_id' => $data['platform_id'],
           'suburb_id' => $data['suburb_id']
        ])->limit(1)->one();

        if ($model != null) {
            $model->_model = clone $model;
            $model->tags = $data['tags'];
            $model->setAttributes($data);
            $model->status = $model::STATUS_ACTIVE;
            if ($model->save()) {
                return true;
            }else {
                throw new \Exception('Error Update Model: ' . \json_encode($model->errors));
                return false;
            }
        }

        /* Create */

        $model = new Delivery();
        $model->tags = $data['tags'];
        $model->setAttributes($data);
        if ($model->save()) {
            return true;
        }else {
            throw new \Exception('Error Create\Update Model: ' . \json_encode($model->errors));
            return false;
        }
    }

    /* Filters */

    protected function categoryFilter($title)
    {
        $aliases = [
           'burger' => 'burgers',
           'cake' => 'cakes',
           'caf�' => 'cof',
           'dessert' => 'desserts',
           'dumpling' => 'dumplings',
           'fish & chips' => 'fish and chips',
           'gluten-free' => 'gluten free',
           'gluten-free friendly' => 'gluten free',
           'ice cream' => 'ice cream and frozen yoghurt',
           'ice cream & frozen yogurt' => 'ice cream and frozen yoghurt',
           'juice' => 'juices',
           'latin-american' => 'latin american',
           'salad' => 'salads',
           'sandwich' => 'sandwiches',
           'snack' => 'snacks',
        ];
        $title = trim(strip_tags($title));
        if (key_exists($title, $aliases)) {
            return $aliases[$title];
        }
        return $title;
    }

    /* Lists */

    protected function stateList()
    {
        $this->states = Suburb::find()->select('id')->where(['is_state' => Suburb::IS_STATE])->indexBy('title')->column();
    }

    protected function platformList()
    {
        $this->platforms = Platform::find()->select('id')->indexBy('code_api')->column();
    }

    protected function cuisineTypesList()
    {
        $this->cuisineTypes = CuisineTypes::find()->select('id')->indexBy('code_api')->column();
    }

}