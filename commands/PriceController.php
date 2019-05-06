<?php

namespace app\commands;

use app\models\RequestPricesForm;
use Yii;
use yii\console\Controller;

class PriceController extends Controller
{

    public function actionMakeRequest()
    {
        $model = new RequestPricesForm();
        $prices = [];
        if ($model->load(Yii::$app->request->post())) {
            $prices = $this->pricesApi->getPrices($model->companySymbol, $model->startDate, $model->endDate);
        }

        return $this->render('index', [
            'model' => $model,
            'prices' => $prices,
        ]);
    }
}