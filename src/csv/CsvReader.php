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
    private array $result;

    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import()
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException('Файл не найден');
        }

        $this->file = new SplFileObject($this->filename);


        // $header_data = $this->getHeaderData();

        // if (trim($header_data) !== implode(',', $this->columns)) {
        //     throw new FileFormatException('Исходный файл не содержит необходимых столбцов');
        // }

        while ($line = $this->getNextLine()) {
            $this->result[] = $line;
        }
    }

    public function getData(): array
    {
        return $this->result;
    }

    public function getSql()
    {
        $data = $this->result;
        $tableName = 'cities';

        $result = [];
        foreach ($data as $row) {
            $columns = 'city_name, city_lon, city_lat';
            $values = "'" . implode("', '", $row) . "'";

            $sql = "INSERT INTO $tableName ($columns) VALUES ($values);";

            $result[] = $sql;
        }

        return array_slice($result, 1);
    }

    private function getHeaderData()
    {
        $this->file->seek(0);
        $data = $this->file->fgetcsv();

        return implode(',', $data);
    }

    private function getNextLine()
    {
        $result = null;

        if (!$this->file->eof()) {
            $result = $this->file->fgetcsv();
        }

        return $result;
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
