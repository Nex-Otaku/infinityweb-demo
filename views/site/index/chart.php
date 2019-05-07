<?php

/* @var $this yii\web\View */
/* @var $prices array */

$chartConfiguration = [
    'type'         => 'serial',
    'dataProvider' => $prices,
    'categoryField' =>  'Date',
    'categoryAxis' => ['gridPosition' => 'start'],
    'valueAxes'    => [
        [
            'id' => 'priceAxis',
            'axisAlpha' => 0.2,
            'position' => 'left'
        ],
        [
            'id' => 'volumeAxis',
            'axisAlpha' => 0.2,
            'position' => 'right'
        ],
    ],
    'graphs'       => [
        [
            'valueAxis' => 'priceAxis',
            'type' => 'line',
            'title' => 'Open',
            'valueField' => 'Open',
        ],
        [
            'valueAxis' => 'priceAxis',
            'type' => 'line',
            'title' => 'High',
            'valueField' => 'High',
        ],
        [
            'valueAxis' => 'priceAxis',
            'type' => 'line',
            'title' => 'Low',
            'valueField' => 'Low',
        ],
        [
            'valueAxis' => 'priceAxis',
            'type' => 'line',
            'title' => 'Close',
            'valueField' => 'Close',
        ],
        [
            'valueAxis' => 'volumeAxis',
            'type' => 'line',
            'title' => 'Volume',
            'valueField' => 'Volume',
        ],
    ],
];
echo speixoto\amcharts\Widget::widget(['chartConfiguration' => $chartConfiguration]);
