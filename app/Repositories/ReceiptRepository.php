<?php

namespace App\Repositories;

use App\Models\Receipt;
use App\Repositories\BaseRepository;

class ReceiptRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'order_id',
        'bank_id',
        'bank_program_id',
        'payment_id',
        'invoice_id',
        'individual_entrepreneur_id',
        'status',
        'auth_code',
        'card_mask',
        'sender_card_type',
        'rrn',
        'terminal',
        'owner_name'
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
        return Receipt::class;
    }
}
