<?php

namespace app\models;

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
        ];
    }
}