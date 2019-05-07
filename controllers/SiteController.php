<?php

namespace app\controllers;

use app\components\prices_api\PricesApi;
use app\models\RequestPricesForm;
use Yii;
use yii\base\Module;
use yii\web\Controller;

class SiteController extends Controller
{
    private $pricesApi;

    public function __construct(
        string $id,
        Module $module,
        PricesApi $pricesApi,
        array $config = []
    )
    {
        $this->pricesApi = $pricesApi;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new RequestPricesForm();
        $prices = [];
        $hasPrices = false;
        if ($model->load(Yii::$app->request->post())) {
            $pricesApiResponse = $this->pricesApi->getPrices($model->companySymbol, $model->startDate, $model->endDate);
            $hasPrices = $pricesApiResponse->isSuccess;
            if ($hasPrices) {
                $prices = $pricesApiResponse->data;
            }
        }

        return $this->render('index', [
            'model' => $model,
            'hasPrices' => $hasPrices,
            'prices' => $prices,
        ]);
    }
}
