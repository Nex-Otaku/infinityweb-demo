<?php

namespace app\components\company_symbol_validator;

use yii\validators\Validator;

class CompanySymbolValidator extends Validator
{
    private const COMPANY_NOT_FOUND = 'Не найдена компания.';

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
            $this->addError($model, $attribute, self::COMPANY_NOT_FOUND);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view): string
    {
        $symbols = json_encode($this->companySymbolStorage->getAll());
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
if ($.inArray(value, {$symbols}) === -1) {
    messages.push($message);
}
JS;
    }

    private function exists(string $companySymbol): bool
    {
        $symbols = $this->companySymbolStorage->getAll();
        return in_array($companySymbol, $symbols);
    }
}