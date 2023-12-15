<?php

use taskforce\logic\actions\ResponseAction;
use taskforce\logic\AvailableActions;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);
$nextStatus = $strategy->getNextStatus(new ResponseAction());
echo $nextStatus;

// assert($strategy->getNextStatus(AvailableActions::ACTION_CANCEL) == AvailableActions::STATUS_COMPLETE, 'cancel action');

