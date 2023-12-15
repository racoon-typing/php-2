<?php

use taskforce\logic\AvailableActions;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);

$newToPerformer = $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 2);
var_dump('new -> performer', !empty($newToPerformer));

$newToClientAlien = $strategy->getAvailableActions(AvailableActions::ROLE_CLIENT, 2);
var_dump('new -> client,alien', !empty($newToClientAlien));

$newToClientSame = $strategy->getAvailableActions(AvailableActions::ROLE_CLIENT, 1);
var_dump('new -> client,same', !empty($newToClientSame));

$proceedToPerformerSame = $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 3);
var_dump('proceed -> performer,same', !empty($proceedToPerformerSame));
