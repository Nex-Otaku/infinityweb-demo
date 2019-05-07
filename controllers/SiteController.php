<?php

namespace app\controllers;

use app\components\prices_api\PricesApi;
use app\models\RequestPricesForm;
use Yii;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
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
                $prices = $this->convertPrices($pricesApiResponse->data);
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

    private function convertPrices(?array $data): array
    {
        if ($data === null) {
            return [];
        }
        $rows = ArrayHelper::getValue($data, 'dataset.data', []);
        if (\count($rows) === 0) {
            return [];
        }

        $prices = [];
        $columns = ArrayHelper::getValue($data, 'dataset.column_names', []);
        $allowedColumns = ['Date', 'Open', 'High', 'Low', 'Close', 'Volume'];
        foreach ($rows as $row) {
            $dayPrice = [];
            foreach ($row as $columnIndex => $value) {
                $columnName = $columns[$columnIndex];
                if (!in_array($columnName, $allowedColumns)) {
                    continue;
                }
                $dayPrice[$columnName] = $value;
            }
            $prices []= $dayPrice;
        }
        return $prices;
    }
}
