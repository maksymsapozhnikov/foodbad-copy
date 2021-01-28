<?php

namespace console\helpers;

use common\models\CuisineTypes;
use common\models\CuisineTypesAssn;
use Yii;

class CategoriesInit
{

    protected $cuisineTypes = [];

    public function __construct()
    {
        $this->cuisineTypes = CuisineTypes::find()->select('id')->indexBy('code_api')->column();
    }

    const ITEMS = [
       'American' => ['American', 'Bbq', 'Burgers', 'Fried chicken', 'Grill', 'Steak', 'Wings', 'Wraps'],
       'Asian' => ['Asian', 'Asian fusion', 'Burmese', 'Cantonese', 'Chinese', 'Dim sum', 'Dumplings', 'Pho', 'Fusion', 'Hot pot', 'Tea', 'Korean', 'Malaysian', 'Nepalese', 'Noodles', 'Singaporean'],
       'Bakery' => ['Bakery', 'Bagels', 'Cakes', 'Pie'],
       'Burgers' => ['Burgers', 'Chicken', 'Aus burger', 'Comfort food'],
       'Cafe' => ['Cafe', 'Afternoon tea', 'Breakfast', 'Breakfast and brunch', 'Brunch', 'Caf', 'Cakes', 'Chocolatier', 'Coffee', 'Coffee and tea', 'Milkshakes', 'Sandwiches', 'Tea', 'Wraps'],
       'Fast food' => ['Fast food', 'Aus burger', 'Chicken', 'Comfort food', 'Fried chicken', 'Kebab', 'Wraps', 'Fish and chips'],
       'European' => ['European', 'Belgian', 'german', 'French'],
       'Indian' => ['Indian', 'Bengali', 'Curry', 'Indian curry', 'North indian', 'Pakistani', 'Ramen', 'South indian', 'Sri lankan'],
       'British' => ['British', 'Bubble tea', 'Irish'],
       'Italian' => ['Italian', 'Mezze', 'Pasta', 'Pizza'],
       'Japanese' => ['Japanese', 'Sushi'],
       'Health Food' => ['Health Food', 'Acai', 'Chicken', 'Healthy', 'Juices', 'Organic', 'Poke', 'Rice bowls', 'Salads', 'Smoothie', 'Soul food', 'Wraps'],
       'Mexican' => ['Mexican', 'Burritos', 'Tacos', 'Tex mex'],
       'Middle eastern' => ['Middle eastern', 'Afghan', 'Falafel', 'Halal', 'Iranian', 'Israeli', 'Mezze', 'Persian'],
       'Mediterranean' => ['Mediterranean', 'Balkan', 'Italian', 'Lebanese', 'Mezze', 'Portuguese', 'Seafood', 'Tapas', 'Turkish', 'Spanish', 'Greek'],
       'Vegan' => ['Vegan', 'Vegan friendly'],
       'Other' => ['Other', 'Drinks', 'Allergy friendly', 'Family meals', 'Gluten free', 'Gourmet'],
       'Desserts' => ['Desserts', 'Gelato', 'Chocolatier', 'Donuts', 'Ice cream', 'Ice cream and frozen yoghurt', 'Milkshakes', 'Pancakes'],
       'Convenience' => ['Convenience', 'Alcohol', 'Everyday essentials', 'Grocery', 'Snacks'],
       'South east asian' => ['South east asian', 'Filipino', 'Indonesian', 'Pho', 'Taiwanese', 'Tea', 'Thai', 'Vietnamese', 'Hawaiian'],
       'Latin american' => ['Latin american', 'South american', 'Cuban'],
    ];

    public function link()
    {
        CuisineTypesAssn::deleteAll();
        foreach (self::ITEMS as $key => $val) {
            $array = $this->buildArray($key, $val);
            if ($array != []) {
                foreach ($array as $tag => $type) {
                    $model = new CuisineTypesAssn();
                    $model->setAttributes([
                       'tag_id' => (int) $tag,
                       'type_id' => (int) $type
                    ]);
                    if(!$model->save()){
                        echo "Error! " . \json_encode($model->errors) . "\n";
                    }
                }
            }
        }
        echo "Done! \n";
    }

    protected function buildArray($key, $items)
    {
        $array = [];
        $key = strtolower($key);
        if (key_exists($key, $this->cuisineTypes)) {

            $cID = $this->cuisineTypes[$key];
            if (is_array($items)) {
                foreach ($items as $item) {
                    $item = strtolower($item);
                    if (key_exists($item, $this->cuisineTypes)) {
                        $array[$this->cuisineTypes[$item]] = $cID;
                    }
                }
            }
        }else {
            echo "Category {$key} not found \n";
        }
        return $array;
    }


}