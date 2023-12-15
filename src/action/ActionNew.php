<?php

namespace taskforce\action;

use taskforce\abstract\Action as AbstractAction;

class ActionNew extends AbstractAction
{
    private $name;
    private $action;

    public function __construct(string $name, string $action)
    {
        $this->name = $name;
        $this->action = $action;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getAccess(int $performerId, int $userId): bool
    {
        return $performerId == $userId ? true : false;
    }
}
