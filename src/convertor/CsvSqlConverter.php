<?php

class CsvSqlConverter {
    protected array $filesToConvert = [];

    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new ConverterException('Указанная директория не существует');
        }

        $this->loadCsvFiles($directory);
    }

    // loadCsvFiles
}