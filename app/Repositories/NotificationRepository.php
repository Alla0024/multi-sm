<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'type',
        'name',
        'phone',
        'product_id',
        'comment',
        'notification_status',
        'notification_user_id',
        'client_ip',
        'store_id',
        'client_user_agent'
    ];

    protected array $additionalFields = [
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    public function model(): string
    {
        return Notification::class;
    }
}
