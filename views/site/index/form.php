<?php

use app\models\RequestPricesForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model RequestPricesForm */
/* @var $hasPrices bool */
/* @var $prices array */

$form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'companySymbol')->textInput() ?>

    <?= $form->field($model, 'startDate') ?>

    <?= $form->field($model, 'endDate') ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
