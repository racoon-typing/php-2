<?php

namespace taskforce\abstract;

abstract class Action
{
    abstract public function getName();

    abstract public function getAction();

    abstract public function getAccess(int $performerId, int $userId): bool;
}
