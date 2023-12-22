<?php

class CsvSqlConverter
{
    protected array $filesToConvert = [];

    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new ConverterException('Указанная директория не существует');
        }

        $this->loadCsvFiles($directory);
    }

    public function convertFiles(string $outputDirectory)
    {
        $result = [];

        foreach ($this->filesToConvert as $file) {
            $result[] = $this->convertFile($file, $outputDirectory);
        }

        return $result;
    }

    protected function convertFile(SplFileInfo $file, string $outputDirectory)
    {
        $fileObject = new SplFileObject($file->getRealPath());
        $fileObject->setFlags(SplFileObject::READ_CSV);

        $columns = $fileObject->fgetcsv();
        $values = [];

        while (!$fileObject->eof()) {
            $values[] = $fileObject->fgetcsv();
        }

        $tableName = $file->getBasename('.csv');
        $sqlContent = $this->getSqlContent($tableName, $columns, $values);

        return $this->saveSqlContent($tableName, $outputDirectory, $sqlContent);
    }

    protected function getSqlContent(string $tableName, array $columns, array $values): string
    {
        $columnsString = implode(', ', $columns);

        $sql = "INSERT INTO $tableName ($columnsString) VALUES ";

        foreach ($values as $row) {
            array_walk($row, function (&$value) {
                $value = addslashes($value);
                $value = "'$value'";
            });

            $sql .= "( " . implode(', ', $row) . "), ";
        }

        $sql = substr($sql, 0, -2);

        return $sql;
    }



    protected function loadCsvFiles(string $directory)
    {
        foreach (new DirectoryIterator($directory) as $file) {
            if ($file->getExtension() == 'csv') {
                $this->filesToConvert[] = $file->getFileInfo();
            }
        }
    }
}
