<?php

use taskforce\logic\AvailableActions;
use taskforce\logic\exception\StatusActionException;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


try {
    $strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);

    $strategy->setStatus(AvailableActions::STATUS_CANCEL);
    $strategy->getAvailableActions('performer2', 2);
} catch (StatusActionException $e) {
    $errorMessage = 'Ошибка при установке статуса: ' . $e->getMessage();
    echo $errorMessage;
    error_log($errorMessage, 3, 'error.log');
} 

// $newToPerformer = $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 2);
// var_dump('new -> performer', !empty($newToPerformer));
