<?php
namespace backend\components;
use common\models\CuisineTypes;
use common\models\CuisineTypesAssn;

class Helpers
{
    /**
     * @param $category int
     * @param $ids array
     * @return boolean
     */
    public static function categoryTagsAssn(int $category, $ids){
        if(CuisineTypes::find()->where(['id' => $category,'category' => CuisineTypes::CATEGORY_MAIN])->exists()){
            CuisineTypesAssn::deleteAll(['type_id' => $category]);
            foreach ($ids as $id){
                $model = new CuisineTypesAssn();
                $model->setAttributes(['type_id' => $category,'tag_id' => $id]);
                $model->save();
            }
            return true;
        }
        return false;
    }

    public static function arrayToString($array, $explode = ', '): string
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