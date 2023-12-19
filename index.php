<?php

use taskforce\logic\AvailableActions;
use taskforce\logic\exception\StatusException;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


try {
    $strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);

    $this->setStatus(AvailableActions::STATUS_CANCEL);
} catch (StatusException $e) {
    error_log('Ошибка при установке статуса' . $e->getMessage());
} catch () {

} 

$newToPerformer = $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 2);
var_dump('new -> performer', !empty($newToPerformer));

$newToClientAlien = $strategy->getAvailableActions(AvailableActions::ROLE_CLIENT, 2);
var_dump('new -> client,alien', !empty($newToClientAlien));

$newToClientSame = $strategy->getAvailableActions(AvailableActions::ROLE_CLIENT, 1);
var_dump('new -> client,same', !empty($newToClientSame));

$proceedToPerformerSame = $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 3);
var_dump('proceed -> performer,same', !empty($proceedToPerformerSame));
