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

    public function actionMakeRequest()
    {
        $prices = $this->pricesApi->getPrices('WBAI', '1999-01-01', '2019-01-01');
        var_dump($prices);
    }
}