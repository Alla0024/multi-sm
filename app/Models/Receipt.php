<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public $table = 'receipts';

    public $fillable = [
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

    protected $casts = [
        'order_id' => 'string',
        'status' => 'string',
        'auth_code' => 'string',
        'card_mask' => 'string',
        'sender_card_type' => 'string',
        'rrn' => 'string',
        'terminal' => 'string',
        'owner_name' => 'string'
    ];

    public static array $rules = [
        'order_id' => 'nullable|string|max:255',
        'bank_id' => 'nullable',
        'bank_program_id' => 'nullable',
        'payment_id' => 'nullable',
        'invoice_id' => 'nullable',
        'individual_entrepreneur_id' => 'nullable',
        'status' => 'required|string|max:255',
        'auth_code' => 'nullable|string|max:255',
        'card_mask' => 'nullable|string|max:255',
        'sender_card_type' => 'nullable|string|max:255',
        'rrn' => 'nullable|string|max:255',
        'terminal' => 'nullable|string|max:255',
        'owner_name' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function bank(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Bank::class, 'bank_id');
    }

    public function bankProgram(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\BankProgram::class, 'bank_program_id');
    }

    public function individualEntrepreneur(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\IndividualEntrepreneur::class, 'individual_entrepreneur_id');
    }

    public function payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\PaymentMethod::class, 'payment_id');
    }
}
