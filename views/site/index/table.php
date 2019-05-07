<?php

/* @var $this yii\web\View */
/* @var $pricesProvider ArrayDataProvider */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;

?>
<?= GridView::widget([
    'dataProvider' => $pricesProvider,
]);
