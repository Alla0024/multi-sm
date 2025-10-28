<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodDescription extends Model
{
    public $table = 'payment_method_descriptions';

    public $fillable = [
        'language_id',
        'title',
        'comment'
    ];

    protected $casts = [
        'title' => 'string',
        'comment' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'title' => 'required|string|max:255',
        'comment' => 'required|string|max:65535'
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }

    public function paymentMethod(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\PaymentMethod::class, 'payment_method_id');
    }
}
