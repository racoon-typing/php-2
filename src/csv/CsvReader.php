<?php

namespace taskforce\csv;

use SplFileObject;
use taskforce\exception\FileFormatException;
use taskforce\exception\SourceFileException;

class CsvReader
{
    private string $filename;
    private array $columns;
    private $file;

    private array $result = [];


    /**
     * ContactsImporter constructor.
     * @param $filename
     * @param $columns
     */
    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import(): void
    {
        $this->file = new SplFileObject($this->filename, 'r');
        $this->file->setCsvControl(',');

        foreach ($this->file as $row) {
            yield $row;
        }

        foreach ($csvData as $row) {
            $this->getNextLine();
            $this->result[] = $row;
            echo implode(', ', $row) . PHP_EOL;
        }

        // if (!$this->validateColumns($this->columns)) {
        //     throw new FileFormatException("Заданы неверные заголовки столбцов");
        // }

        // if (!file_exists($this->filename)) {
        //     throw new SourceFileException("Файл не существует");
        // }

        // $this->file = new SplFileObject($this->filename, 'r');

        // if (!$this->file) {
        //     throw new SourceFileException("Не удалось открыть файл на чтение");
        // }

        // $header_data = $this->getHeaderData();

        // if ($header_data !== $this->columns) {
        //     throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        // }

        // while ($line = $this->getNextLine()) {
        //     $this->result[] = $line;
        // }
    }

    public function getData(): array
    {
        return $this->result;
    }

    private function getHeaderData(): ?array
    {
        $this->file->seek(0);
        $data = $this->file->fgetcsv();

        return $data;
    }

    private function getNextLine(): ?array
    {

        // $result = null;

        // if (!$this->file->eof()) {
        //     $result = $this->file->fgetcsv();
        // }

        // return $result;
    }

    private function validateColumns(array $columns): bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }
}
