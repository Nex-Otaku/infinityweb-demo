<?php

namespace app\commands;

use app\components\prices_api\PricesApi;
use yii\console\Controller;

class PriceController extends Controller
{
    private $pricesApi;

    public function __construct(
        $id,
        $module,
        PricesApi $pricesApi,
        $config = []
    )
    {
        $this->pricesApi = $pricesApi;
        parent::__construct($id, $module, $config);
    }

    public function actionMakeRequest(): void
    {
        $pricesResponse = $this->pricesApi->getPrices('ATML', '2010-01-01', '2011-01-01');
        $isSuccess = $pricesResponse->isSuccess ? 'true' : 'false';
        $errorMessage = $pricesResponse->errorMessage;
        $prices = print_r($pricesResponse->data, true);

        echo "Is success: {$isSuccess}\n"
            . "Error: {$errorMessage}\n"
            . "Prices: $prices\n";
    }
}