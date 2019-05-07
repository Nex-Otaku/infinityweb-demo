<?php

/* @var $this yii\web\View */
/* @var $model RequestPricesForm */
/* @var $hasPrices bool */
/* @var $pricesProvider ArrayDataProvider */
/* @var $prices array */

use app\models\RequestPricesForm;
use yii\data\ArrayDataProvider;

$this->title = 'Demo InfinityWeb';
?>
<div class="site-index">
    <div class="body-content">
        <?= $this->render('index/form', [
            'model' => $model,
        ]) ?>
        <?php if ($hasPrices): ?>
            <?= $this->render('index/table', [
                'pricesProvider' => $pricesProvider,
            ]) ?>

            <?= $this->render('index/chart', [
                'prices' => $prices,
            ]) ?>
        <?php else: ?>
            <p>Не удалось получить данные.</p>
        <?php endif; ?>
    </div>
</div>
