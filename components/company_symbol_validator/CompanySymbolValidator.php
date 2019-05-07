<?php

namespace app\components\company_symbol_validator;

use yii\validators\Validator;

class CompanySymbolValidator extends Validator
{
    private $companySymbolStorage;

    public function __construct(
        CompanySymbolStorage $companySymbolStorage,
        array $config = []
    )
    {
        parent::__construct($config);
        $this->companySymbolStorage = $companySymbolStorage;
    }

    public function validateAttribute($model, $attribute): void
    {
        $companySymbol = $model->$attribute;

        if (!$this->exists($companySymbol)) {
            $this->addError($model, $attribute, 'Не найдена компания.');
        }
    }

    private function exists(string $companySymbol): bool
    {
        $symbols = $this->companySymbolStorage->getAll();
        return in_array($companySymbol, $symbols);
    }
}