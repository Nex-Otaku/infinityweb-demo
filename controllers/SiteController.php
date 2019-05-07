<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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
        if ($model->load(Yii::$app->request->post())) {
            $prices = $this->pricesApi->getPrices($model->companySymbol, $model->startDate, $model->endDate);
        }

        return $this->render('index', [
            'model' => $model,
            'prices' => $prices,
        ]);
    }
}
