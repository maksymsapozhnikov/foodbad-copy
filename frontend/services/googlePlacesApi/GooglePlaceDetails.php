<?php

namespace frontend\services\googlePlacesApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Yii;

class GooglePlaceDetails
{
    protected $httpClient;
    protected $project_key;
    const HOST = 'https://maps.googleapis.com/maps/api/place/details/json';
    protected $query;
    protected $place_id;

    function __construct($place_id)
    {
        $this->place_id = $place_id;
        $this->project_key = \Yii::$app->params['google_api_key'];
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

    public function placeDetails(){
        return $this->makeRequest($this->createUrl());
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
        return $data['status'] == 'OK' ? $data['result'] : [];
    }

    private function createUrl()
    {
        return '?' . http_build_query([
              'place_id' => $this->place_id,
              'key' => $this->project_key
           ]);
    }

}