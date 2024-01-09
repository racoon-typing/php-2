<?php

namespace taskforce\logic\actions;

use taskforce\logic\actions\AbstractAction;

class DenyAction extends AbstractAction
{
    public static function getLabel(): string
    {
        return 'Отказаться';
    }

    public static function getInternalName(): string
    {
        return 'act_deny';
    }

    public static function checkRights(int $userId, ?int $performerId, ?int $clientId): bool
    {
        return $userId == $performerId;
    }
}
