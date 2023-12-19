<?php

namespace taskforce\logic;

use taskforce\logic\actions\CancelAction;
use taskforce\logic\actions\CompleteAction;
use taskforce\logic\actions\DenyAction;
use taskforce\logic\actions\ResponseAction;
use taskforce\logic\exception\AvailableActionsException;
use taskforce\logic\exception\StatusException;

class AvailableActions
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'proceed';
    const STATUS_CANCEL = 'cancel';
    const STATUS_COMPLETE = 'complete';
    const STATUS_EXPIRED = 'expired';

    const ROLE_PERFORMER = 'performer';
    const ROLE_CLIENT = 'customer';

    private ?int $performerId;
    private int $clientId;

    private $status;

    /**
     * AvailableActionsStrategy constructor.
     * @param string $status
     * @param int|null $performerId
     * @param int $clientId
     */
    public function __construct(string $status, int $clientId, ?int $performerId = null)
    {
        $statuses = [
            self::STATUS_NEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_CANCEL,
            self::STATUS_COMPLETE,
            self::STATUS_EXPIRED
        ];

        if (!in_array($status, $statuses)) {
            throw new StatusException('Указан невалидный статус');
        }

        $this->setStatus($status);

        $this->performerId = $performerId;
        $this->clientId = $clientId;
    }

    public function getAvailableActions(string $role, int $id)
    {
        $roles = [
            self::ROLE_CLIENT,
            self::ROLE_PERFORMER,
        ];

        if (!in_array($role, $roles)) {
            throw new AvailableActionsException('Указанная роль недейтсвительна');
        }

        $statusActions = $this->statusAllowedActions()[$this->status];
        $roleActions = $this->roleAllowedActions()[$role];

        $allowedActions = array_intersect($statusActions, $roleActions);

        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::checkRights($id, $this->performerId, $this->clientId);
        });

        return array_values($allowedActions);
    }

    public function getNextStatus(string $action)
    {
        $map = [
            CompleteAction::class => self::STATUS_COMPLETE,
            CancelAction::class => self::STATUS_CANCEL,
            DenyAction::class => self::STATUS_CANCEL,
            ResponseAction::class => null
        ];

        return $map[$action];
    }

    /**
     * @param string $status
     * @return void
     */
    private function setStatus(string $status): void
    {
        $availableStatuses = [
            self::STATUS_NEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_CANCEL,
            self::STATUS_COMPLETE,
            self::STATUS_EXPIRED
        ];

        if (in_array($status, $availableStatuses)) {
            $this->status = $status;
        }
    }

    /**
     * Возвращает действия, доступные для каждой роли
     * @return array
     */
    private function roleAllowedActions()
    {
        $map = [
            self::ROLE_CLIENT => [CancelAction::class, CompleteAction::class],
            self::ROLE_PERFORMER => [ResponseAction::class, DenyAction::class]
        ];

        return $map;
    }

    /**
     * Возвращает действия, доступные для указанного статуса
     * @return array
     */
    private function statusAllowedActions()
    {
        $map = [
            self::STATUS_CANCEL => [],
            self::STATUS_COMPLETE => [],
            self::STATUS_IN_PROGRESS => [DenyAction::class, CompleteAction::class],
            self::STATUS_NEW => [CancelAction::class, ResponseAction::class],
            self::STATUS_EXPIRED => []
        ];

        return $map;
    }

    private function getStatusMap()
    {
        $map = [
            self::STATUS_NEW => [self::STATUS_EXPIRED, self::STATUS_CANCEL],
            self::STATUS_IN_PROGRESS => [self::STATUS_CANCEL, self::STATUS_COMPLETE],
            self::STATUS_CANCEL => [],
            self::STATUS_COMPLETE => [],
            self::STATUS_EXPIRED => [self::STATUS_CANCEL]
        ];

        return $map;
    }
}
