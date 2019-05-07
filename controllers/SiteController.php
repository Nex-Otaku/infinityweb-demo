<?php

namespace app\controllers;

use app\components\prices_api\PricesApi;
use app\models\RequestPricesForm;
use components\prices_converter\PricesConverter;
use Yii;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{
    private $pricesApi;
    private $pricesConverter;

    public function __construct(
        string $id,
        Module $module,
        PricesApi $pricesApi,
        PricesConverter $pricesConverter,
        array $config = []
    )
    {
        $this->pricesApi = $pricesApi;
        $this->pricesConverter = $pricesConverter;
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
                $prices = $this->pricesConverter->convertFromApi($pricesApiResponse->data);
            }
        }

        $pricesProvider = new ArrayDataProvider([
            'allModels' => $prices,
            'key' => 'Date',
            'pagination' => false,
        ]);

        return $this->render('index', [
            'model' => $model,
            'hasPrices' => $hasPrices,
            'pricesProvider' => $pricesProvider,
        ]);
    }
}
