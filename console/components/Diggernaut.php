<?php

namespace console\components;


use common\models\Delivery;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Yii;

class Diggernaut
{
    protected $httpClient;
    const PROJECT_KEY = 'Token 81d4987dd5c9eb73c3eb74c12d2ad55dbdee3142';
    const HOST        = 'https://www.diggernaut.com/api/';

    function __construct()
    {
        $this->httpClient = new Client(['base_uri' => self::HOST]);
    }

    protected function makeRequest($url)
    {
        try{
            $response = $this->httpClient->request('GET', $url, [
               'headers' => [
                  'Authorization' => self::PROJECT_KEY,
                  'Accept' => 'application/json',
                  'timeout'  => 2
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

    protected function responseDataDecode($data)
    {
        $data = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decode data');
            return [];
        }
        return $data;
    }

    public function run()
    {
        try{
            $diggerIds = Yii::$app->params['local_digger_ids'] ?? Yii::$app->params['digger_ids'];
            Delivery::updateAll(['status' => Delivery::STATUS_INACTIVE], ['status' => Delivery::STATUS_ACTIVE]);
            foreach ($diggerIds as $diggerId) {
                echo 'Run digger# ' . $diggerId . "\n";
                $data = $this->makeRequest('diggers/' . $diggerId);
                if (!empty($data['last_session']['id'])) {
                    echo "Session# " . $data['last_session']['id'] . "\n";
                    $url = "sessions/{$data['last_session']['id']}/data";
                    (new DataHandler())->sessionParse($this->makeRequest($url));
                }
            }

        }catch (\Throwable $e){
            Yii::error($e->getMessage() . ', FILE: ' . $e->getFile() . ', LINE: ' . $e->getLine(), 'Diggernaut/API');
        }

        echo 'Done';
    }

}