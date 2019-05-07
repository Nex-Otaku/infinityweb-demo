<?php

namespace app\components\prices_api;

use yii\httpclient\Client;

class PricesApi
{
    private const API_BASE_URL = 'https://www.quandl.com/api/v3/datasets/WIKI/';
    private const FORMAT_SUFFIX = '.json';

    public function getPrices(string $companySymbol, string $startDate, string $endDate): ApiResponse
    {
        $client = new Client();
        $url = $this->getUrl($companySymbol);
        $apiKey = $this->getApiKey();

        /* @var $response \yii\httpclient\Response */
        $exception = false;
        try {
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($url)
                ->setData([
                    'order' => 'asc',
                    'star_date' => $startDate,
                    'end_date' => $endDate,
                    'api_key' => $apiKey,
                ])
                ->send();
        } catch (\Exception $e) {
            $exception = true;
        }
        if ($exception || !$response->isOk || !is_array($response->data)) {
            return $this->buildFailResponse();
        }
        return $this->buildSuccessResponse($response->data);
    }

    private function getUrl(string $companySymbol)
    {
        return self::API_BASE_URL
            . $companySymbol
            . self::FORMAT_SUFFIX;
    }

    private function getApiKey()
    {
        return Yii::$app->params['quandl.apiToken'];
    }

    private function buildFailResponse()
    {
        return new ApiResponse(
            false,
            null
        );
    }

    private function buildSuccessResponse($data)
    {
        return new ApiResponse(
            true,
            $data
        );
    }
}