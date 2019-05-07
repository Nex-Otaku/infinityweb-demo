<?php

namespace app\components\prices_api;

use Yii;
use yii\httpclient\Client;
use yii\httpclient\Response;

class PricesApi
{
    private const API_BASE_URL = 'https://www.quandl.com/api/v3/datasets/WIKI/';
    private const FORMAT_SUFFIX = '.json';

    public function getPrices(string $companySymbol, string $startDate, string $endDate): ApiResponse
    {
        $client = new Client();
        $url = $this->getUrl($companySymbol);
//        die($url);
//        die($companySymbol);
        $apiKey = $this->getApiKey();

        /* @var $response \yii\httpclient\Response */
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
            return $this->buildFailResponse($e->getMessage());
        }
        if (!$response->isOk) {
            $errorMessage = $this->extractHttpError($response);
            return $this->buildFailResponse($errorMessage);
        }
        if (!is_array($response->data)) {
            return $this->buildFailResponse('Некорректный формат ответа API');
        }
        return $this->buildSuccessResponse($response->data);
    }

    private function getUrl(string $companySymbol): string
    {
        return self::API_BASE_URL
            . $companySymbol
            . self::FORMAT_SUFFIX;
    }

    private function getApiKey(): string
    {
        return Yii::$app->params['quandl.apiToken'];
    }

    private function buildFailResponse(string $errorMessage): ApiResponse
    {
        return new ApiResponse(
            false,
            $errorMessage,
            null
        );
    }

    private function buildSuccessResponse($data): ApiResponse
    {
        return new ApiResponse(
            true,
            '',
            $data
        );
    }

    private function extractHttpError(Response $response): string
    {
        try {
            $statusCode = $response->getStatusCode();
        } catch (\Exception $e) {
            $statusCode = '!!! NO STATUS CODE AVAILABLE !!!';
        }
        $headers = print_r($response->getHeaders()->toArray(), true);
        return "Не удалось выполнить запрос.\n"
                . "Status Code: {$statusCode}.\n"
                . "Headers: {$headers}\n"
                . "Content: {$response->getContent()}";
    }
}