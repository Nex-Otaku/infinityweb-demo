<?php


namespace app\tests\unit\demo\company_symbol_validator;


use app\components\company_symbol_validator\CompanySymbolValidator;
use Codeception\TestCase\Test;
use yii\base\DynamicModel;

class CompanySymbolValidatorTest extends Test
{
    public function testExists(): void
    {
        $this->mustExist('WBAI');
    }

    public function testNotExists(): void
    {
        $this->mustNotExist('RANDOM-COMPANY-SYMBOL');
    }

    private function mustExist(string $companySymbol): void
    {
        $exist = $this->exists($companySymbol);
        $this->assertEquals(true, $exist);
    }

    private function mustNotExist(string $companySymbol): void
    {
        $exist = $this->exists($companySymbol);
        $this->assertEquals(false, $exist);
    }

    private function exists(string $companySymbol)
    {
        $model = new DynamicModel(['companySymbol' => $companySymbol]);
        $model->addRule('companySymbol', CompanySymbolValidator::class);
        $model->validate();
        return !$model->hasErrors();
    }
}