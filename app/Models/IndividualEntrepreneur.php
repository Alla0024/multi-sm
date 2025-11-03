<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndividualEntrepreneur extends Model
{
    public $table = 'individual_entrepreneurs';

    public $fillable = [
        'name',
        'store_id',
        'store_key',
        'token',
        'status',
        'sort_order',
        'bank_id',
        'date_start',
        'date_end'
    ];

    protected $casts = [
        'name' => 'string',
        'store_id' => 'string',
        'store_key' => 'string',
        'token' => 'string',
        'date_start' => 'datetime',
        'date_end' => 'datetime'
    ];

    public static array $rules = [
        'name' => 'nullable|string|max:255',
        'store_id' => 'nullable|string|max:255',
        'store_key' => 'nullable|string|max:255',
        'token' => 'nullable|string|max:255',
        'status' => 'required',
        'sort_order' => 'nullable',
        'bank_id' => 'required',
        'date_start' => 'nullable',
        'date_end' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, IndividualEntrepreneurToPayment::class, 'payment_id', 'individual_entrepreneur_id');
    }

    public function receipts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Receipt::class, 'individual_entrepreneur_id');
    }
}
