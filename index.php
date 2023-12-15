<?php

use taskforce\logic\AvailiableActions;

require_once 'vendor/autoload.php';
ini_set('assets.exseption', 1);


$strategy = new AvailiableActions(AvailiableActions::STATUS_NEW, 3, 1);
assert($strategy->getNextStatus(AvailiableActions::ACTION_CANCEL) == AvailiableActions::STATUS_COMPLETE, 'cancel action');

