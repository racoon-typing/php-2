<?php

namespace taskforce\logic;

class AvailableActions
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'proceed';
    const STATUS_CANCEL = 'cancel';
    const STATUS_COMPLETE = 'complete';
    const STATUS_EXPIRED = 'expired';

    const ACTION_RESPONSE = 'act_response';
    const ACTION_CANCEL = 'act_cancel';
    const ACTION_DENY = 'act_deny';
    const ACTION_COMPLETE = 'act_complete';

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
        $this->setStatus($status);

        $this->performerId = $performerId;
        $this->clientId = $clientId;
    }

    /**
     * @return string[]
     */
    public function getStatusesMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETE => 'Выполнено',
            self::STATUS_EXPIRED => 'Провалено',
        ];
    }

    /**
     * @return string[]
     */
    public function getActionsMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPONSE => 'Откликнуться',
            self::ACTION_COMPLETE => 'Выполнено',
            self::ACTION_DENY => 'Отказаться',
        ];
    }

    /**
     * @param string $action
     * @return string|null
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETE,
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_DENY => self::STATUS_CANCEL,
        ];

        return $map[$action] ?? null;
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
     * Возвращает действия, доступные для указанного статуса
     * @param string $status
     * @return array
     */
    private function statusAllowedActions(string $status): array
    {
        $map = [
            self::STATUS_IN_PROGRESS => [self::ACTION_DENY, self::ACTION_COMPLETE],
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPONSE],
        ];

        return $map[$status] ?? null;
    }
}
