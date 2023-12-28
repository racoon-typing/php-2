<?php
// require_once 'vendor/autoload.php';
// ini_set('assets.exseption', 1);

// use taskforce\convertor\CsvSqlConverter;


// // Мой вариант
// $converter = new CsvSqlConverter('data/csv');
// $result = $converter->convertFiles('data/sql');

// use taskforce\logic\AvailableActions;
// use taskforce\exception\StatusActionException;

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

use taskforce\logic\AvailableActions;

new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
