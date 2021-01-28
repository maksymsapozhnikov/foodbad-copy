<?php

namespace frontend\services\googlePlacesApi;


use common\models\Restaurant;
use common\models\RestaurantImages;

class RestaurantDetails
{
    public $uploadImage = false;

    public $details = [
       'status' => '',
       'name' => '',
       'address' => '',
       'phone_number' => '',
       'website' => '',
       'location' => [
          'lat' => '',
          'lng' => ''
       ],
       'price_level' => '',
       'rating' => '',
       'reviews' => [],
       'photos' => [],
    ];

    /**
     * @param Restaurant $restaurant
     * @return array
     */
    public function getDetails($restaurant)
    {
        if (Restaurant::DETAILS_ENABLED_CACHE && $restaurant->place_details_updated_at !== null && $restaurant->place_details_updated_at > time() && !empty($restaurant->place_details)) {
            return (\unserialize(base64_decode($restaurant->place_details)));
        }
        $placeID = (new GooglePlaceSearch($restaurant))->placeSearch();
        $data = (new GooglePlaceDetails($placeID))->placeDetails();
        $this->parseData($data, $restaurant);
        if (Restaurant::DETAILS_UPLOAD_IMG_GOOGLE && $this->uploadImage) {
            $path = \Yii::getAlias('@console') . '/../yii upload-images/upload ' . $restaurant->id;
            $path .= ($_SERVER['SERVER_NAME'] != 'foodbud.local') ? ' > ' . \Yii::getAlias('@console') . '/runtime/logs/upload_image.log 2>/dev/null &' : '';
            exec('php ' . $path);
        }
        return $this->details;
    }

    /**
     * @param  array $data
     * @param  Restaurant $restaurant
     * @return bool
     */
    private function parseData($data, $restaurant)
    {
        if (!empty($data)) {
            $this->details['status'] = !empty($data) ? 'OK' : '';
            $this->details['name'] = !empty($data['name']) ? strip_tags($data['name']) : '';
            $this->details['address'] = !empty($data['formatted_address']) ? strip_tags($data['formatted_address']) : '';
            $this->details['phone_number'] = !empty($data['international_phone_number']) ? strip_tags($data['international_phone_number']) : '';
            $this->details['website'] = !empty($data['website']) ? strip_tags($data['website']) : '';
            $this->details['price_level'] = !empty($data['price_level']) ? strip_tags($data['price_level']) : '';
            $this->details['rating'] = !empty($data['rating']) ? strip_tags($data['rating']) : '';
            $this->details['location']['lat'] = !empty($data['geometry']['location']['lat']) ? strip_tags($data['geometry']['location']['lat']) : '';
            $this->details['location']['lng'] = !empty($data['geometry']['location']['lng']) ? strip_tags($data['geometry']['location']['lng']) : '';
            $this->details['reviews'] = !empty($data['reviews']) ? $data['reviews'] : '';
            $this->setImages($data, $restaurant);
            if (Restaurant::DETAILS_ENABLED_CACHE) {
                $this->setCache($restaurant);
            }
        }
        return true;
    }

    /**
     * @param Restaurant $restaurant
     * @return int
     */
    protected function setCache($restaurant)
    {
        return $restaurant->updateAttributes([
           'place_details' => base64_encode(\serialize($this->details)),
           'place_details_updated_at' => time() + Restaurant::DETAILS_CACHE_EXPIRE_TIME_BD,
           'price_level' => (!empty($this->details['price_level']) && ($this->details['price_level'] < 5)) ? (int)$this->details['price_level'] : null
        ]);
    }

    protected function setImages($data, $restaurant)
    {
        $check = !RestaurantImages::find()->where(['restaurant_id' => $restaurant->id])->exists();
        if (!empty($data['photos']) && $check) {
            foreach ($data['photos'] as $item) {
                $this->uploadImage = true;
                $model = new RestaurantImages();
                $model->setAttributes([
                   'restaurant_id' => $restaurant->id,
                   'status' => RestaurantImages::STATUS_ACTIVE,
                   'platform' => RestaurantImages::ADDED_GOOGLE_PHOTO,
                   'photo_reference' => $item['photo_reference'],
                   'created_at' => time(),
                ]);
                $model->save();
            }
        }
        return true;
    }
}