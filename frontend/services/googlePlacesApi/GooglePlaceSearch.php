<?php

namespace frontend\services\googlePlacesApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Yii;

class GooglePlaceSearch
{
	 public $restaurant;
	 protected $httpClient;
	 protected $project_key;
	 const HOST = 'https://maps.googleapis.com/maps/api/place/textsearch/json';
	 protected $query;
	 protected $restaurantTitle = '';

	 function __construct($restaurant)
	 {
		  $this->project_key = \Yii::$app->params['google_api_key'];
		  $this->restaurant = $restaurant;
		  $this->httpClient = new Client(['base_uri' => self::HOST]);
	 }

	 protected function makeRequest($url)
	 {
		  try{
				$response = $this->httpClient->request('GET', $url, [
					'headers' => [
						'Accept' => 'application/json',
						'timeout' => 2
					]
				]);
				if ($response->getStatusCode() == 200) {
					 return $this->responseDataDecode($response->getBody()->getContents());
				}
		  }catch (RequestException $e){
				Yii::error(Message::toString($e->getRequest()), 'Error response');
		  }
		  return [];
	 }

	 /**
	  * @param string $data
	  * @return array
	  * @throws \Exception
	  */
	 protected function responseDataDecode($data)
	 {
		  $data = json_decode($data, true);
		  if (json_last_error() !== JSON_ERROR_NONE) {
				throw new \Exception('Error decode data');
				return [];
		  }
		  return $data['status'] == 'OK' ? $data['results'] : [];
	 }

	 /**
	  * @return bool|string
	  */
	 public function placeSearch()
	 {
		  if ($data = $this->searchByType('restaurant')) {
				return $data;
		  }elseif ($data = $this->searchByType('food')) {
				return $data;
		  }
		  return false;
	 }

	 /**
	  * @return string
	  */
	 private function setQueryString()
	 {
		  $this->restaurantTitle = $this->restaurant->title;
		  $state = $this->restaurant->state->title?? '';
		  return $this->restaurantTitle . " in Australia";
	 }

	 /**
	  * @return string
	  */
	 private function createUrl($type)
	 {
		  return '?' . http_build_query([
				  'region' => 'au',
				  'query' => $this->setQueryString(),
				  'keyword' => 'Restaurant ' . $this->restaurantTitle,
				  'language' => 'en',
				  'type' => $type,
				  'key' => $this->project_key
			  ]);
	 }

	 /**
	  * @param $response
	  * @return bool|string
	  */
	 private function placeID($response)
	 {
	 	 foreach ($response as $item) {
		  	 	$name = $item['name']?? null;
		  	 	$place_id = $item['place_id']?? null;
		  	 	$address = $item['formatted_address']?? null;
		  	 	$state = $this->restaurant->state->title?? null;
		  	 	if(!$name || !$address || !$state || !$place_id){
		  	 		 continue;
				}
				$model = new PlaceItemFilter($this->restaurantTitle,$state,$name,$address,$place_id);
				if($id = $model->searchPlaceID()){
					 return $id;
				}
		  }
		  return false;
	 }

	 private function searchByType($type)
	 {
		  $response = $this->makeRequest($this->createUrl($type));
		  if ($response) {
				return $this->placeID($response);
		  }
		  return false;
	 }
}