<?php

namespace taskforce\logic\actions;

use taskforce\logic\actions\AbstractAction;

class CompleteAction extends AbstractAction
{
    public static function getLabel(): string
    {
        return 'Выполнено';
    }

    public static function getInternalName(): string
    {
        return 'act_complete';
    }

    public static function checkRights(int $userId, ?int $performerId, ?int $clientId): bool
    {
        return $userId == $clientId;
    }
}
