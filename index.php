<?php

use taskforce\logic\AvailableActions;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);
assert($strategy->getNextStatus(AvailableActions::ACTION_CANCEL) == AvailableActions::STATUS_COMPLETE, 'cancel action');

