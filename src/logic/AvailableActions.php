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

    private $performerId = null;
    private $clientId = null;

    private $status = null;

    /**
     * AvailableActionsStrategy constructor.
     * @param string $status
     * @param int $performerId
     * @param int $clientId
     */
    public function __construct(string $status, ?int $performerId, int $clientId)
    {
        $this->setStatus($status);

        $this->performerId = $performerId;
        $this->clientId = $clientId;
    }

    public function getNextStatus(string $action)
    {
        $map = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETE,
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_DENY => self::STATUS_CANCEL,
            self::ACTION_RESPONSE => null
        ];

        return $map[$action];
    }

    public function setStatus(string $status)
    {
        $availableStatuses = [self::STATUS_NEW, self::STATUS_IN_PROGRESS, self::STATUS_CANCEL, self::STATUS_COMPLETE,
            self::STATUS_EXPIRED];

        if (in_array($status, $availableStatuses)) {
            $this->status = $status;
        }
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
