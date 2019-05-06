<?php


namespace app\components\company_symbol_validator;


use Yii;

class CompanySymbolStorage
{
    const FILE_MODE_READ = 'r';

    public function getAll(): array
    {
        $symbols = $this->readSymbolsFromCsv('companylist.csv');
        return $symbols;
    }

    private function readSymbolsFromCsv(string $filename): array
    {
        $fileHandle = $this->openOrDie($filename);
        $firstRow = true;
        $symbols = [];

        while (true) {
            $line = $this->readLine($fileHandle);
            if ($line === null) {
                break;
            }
            if ($firstRow) {
                $firstRow = false;
                continue;
            }
            $symbol = $this->extractFirstElementOrDie($line);
            $symbols []= $symbol;
        }

        $this->close($fileHandle);
        return $symbols;
    }

    private function readLine($fileHandle): ?array
    {
        $line = fgetcsv($fileHandle, 0, ',');
        if ($line === null) {
            $this->die('Некорректный дескриптор файла');
        }
        if ($line === false) {
            return null;
        }
        return $line;
    }

    private function die(string $message)
    {
        throw new \Exception($message);
    }

    private function openOrDie(string $filename)
    {
        $path = Yii::getAlias('@app')
            . DIRECTORY_SEPARATOR . 'components'
            . DIRECTORY_SEPARATOR . 'company_symbol_validator'
            . DIRECTORY_SEPARATOR . $filename;

        $fileHandle = fopen($path, self::FILE_MODE_READ);
        if ($fileHandle === false) {
            $this->die('Не удалось открыть файл на чтение');
        }
        return $fileHandle;
    }

    private function extractFirstElementOrDie(array $line): string
    {
        if (\count($line) === 0) {
            $this->die('Неверный формат файла');
        }
        return $line[0];
    }

    private function close($fileHandle): void
    {
        fclose($fileHandle);
    }
}