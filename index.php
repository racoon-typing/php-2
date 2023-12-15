<?php

use taskforce\logic\actions\DenyAction;
use taskforce\logic\AvailableActions;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);
$nextStatus = $strategy->getNextStatus(new DenyAction());

var_dump('new -> performer', $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 2));
var_dump('new -> client,alien', $strategy->getAvailableActions(AvailableActions::ROLE_CLIENT, 2));
var_dump('new -> client,same', $strategy->getAvailableActions(AvailableActions::ROLE_CLIENT, 1));

var_dump('proceed -> performer,same', $strategy->getAvailableActions(AvailableActions::ROLE_PERFORMER, 3));