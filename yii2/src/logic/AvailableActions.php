<?php

namespace taskforce\logic;

use taskforce\logic\actions\AbstractAction;
use taskforce\logic\actions\CancelAction;
use taskforce\logic\actions\CompleteAction;
use taskforce\logic\actions\DenyAction;
use taskforce\logic\actions\ResponseAction;
use taskforce\logic\exception\StatusActionException;


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
    private ?int $clientId;

    private ?string $status = null;

    /**
     * AvailableActionsStrategy constructor.
     * @param string $status
     * @param int|null $performerId
     * @param int $clientId
     */
    public function __construct(string $status, int $clientId, ?int $performerId = null)
    {
        $this->setStatus($status);

        $this->performerId = $performerId;
        $this->clientId = $clientId;
    }

    public function getAvailableActions(string $role, int $id): array
    {
        $this->checkRole($role);

        $statusActions = $this->statusAllowedActions()[$this->status];
        $roleActions = $this->roleAllowedActions()[$role];

        $allowedActions = array_intersect($statusActions, $roleActions);

        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::checkRights($id, $this->performerId, $this->clientId);
        });

        return array_values($allowedActions);
    }

    public function getNextStatus(AbstractAction $action): ?string
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
    public function setStatus(string $status): void
    {
        $availableStatuses = [
            self::STATUS_NEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_CANCEL,
            self::STATUS_COMPLETE,
            self::STATUS_EXPIRED
        ];

        if (!in_array($status, $availableStatuses)) {
            throw new StatusActionException("Неизвестный статус: $status");
        }

        $this->status = $status;
    }

    public function checkRole(string $role): void
    {
        $availableRoles = [self::ROLE_PERFORMER, self::ROLE_CLIENT];

        if (!in_array($role, $availableRoles)) {
            throw new StatusActionException("Неизвестный роль: $role");
        }
    }

    /**
     * Возвращает действия, доступные для каждой роли
     * @return array
     */
    private function roleAllowedActions(): array
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
    private function statusAllowedActions(): array
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

    private function getStatusMap(): array
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
