<?php

namespace app\models;

use app\components\company_symbol_validator\CompanySymbolValidator;
use yii\base\Model;

class RequestPricesForm extends Model
{
    public $companySymbol;
    public $startDate;
    public $endDate;
    public $email;

    public function rules()
    {
        return [
            [['companySymbol', 'startDate', 'endDate'], 'required'],
            ['email', 'email'],
            ['companySymbol', CompanySymbolValidator::class],
            [['startDate', 'endDate'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}