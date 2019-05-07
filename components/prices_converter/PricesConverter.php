<?php

namespace components\prices_converter;

use yii\helpers\ArrayHelper;

class PricesConverter
{
    public function convertFromApi(?array $data): array
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