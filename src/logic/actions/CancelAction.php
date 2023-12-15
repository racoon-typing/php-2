<?php

namespace taskforce\logic\actions;

use taskforce\logic\actions\AbstractAction;

class CancelAction extends AbstractAction
{
    public static function getLabel()
    {
        return 'Отменить';
    }

    public static function getInternalName()
    {
        return 'act_cancel';
    }

    public static function checkRights($userId, $performerId, $clientId)
    {
        return $userId == $clientId;
    }
}
