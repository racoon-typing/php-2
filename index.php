<?php

use taskforce\csv\CsvReader;
use taskforce\exception\FileFormatException;
use taskforce\exception\SourceFileException;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


// Мой вариант
$loader = new CsvReader('./data/cities.csv', ['name', 'lat', 'long']);
$result = [];

try {
    $result = $loader->import();
    // $loader->getSql();

} catch (SourceFileException $e) {
    echo "Не удалось обработать csv файл: " . $e->getMessage();
    error_log("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    echo "Неверная форма файла импорта: " . $e->getMessage();
    error_log("Неверная форма файла импорта: " . $e->getMessage());
}

var_dump($result);



// use taskforce\logic\AvailableActions;
// use taskforce\logic\exception\StatusActionException;


// try {
//     $strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);

//     $strategy->setStatus(AvailableActions::STATUS_CANCEL);
//     $strategy->getAvailableActions('performer2', 2);
// } catch (StatusActionException $e) {
//     $errorMessage = 'Ошибка при установке статуса: ' . $e->getMessage();
//     echo $errorMessage;
//     error_log($errorMessage, 3, 'error.log');
// } 

// $newToPerformer = $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 2);
// var_dump('new -> performer', !empty($newToPerformer));





// $loader = new CsvReader('./data/cities.csv', ['name', 'lat']);
// $result = [];

// try {
//     $loader->import();
//     $result = $loader->getData();
// } catch (SourceFileException $e) {
//     error_log("Не удалось обработать csv файл: " . $e->getMessage());
// } catch (FileFormatException $e) {
//     error_log("Неверная форма файла импорта: " . $e->getMessage());
// }

// var_dump($result);
