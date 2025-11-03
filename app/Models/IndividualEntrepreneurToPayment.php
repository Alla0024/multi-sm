<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class IndividualEntrepreneurToPayment extends Model
{
    use HasCompositeKey;

    public $table = 'individual_entrepreneur_to_payments';

    public $timestamps = false;

    protected $primaryKey = [
        'individual_entrepreneur_id',
        'payment_method_id'
    ];

    public $fillable = [
        'individual_entrepreneur_id',
        'payment_method_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'payment_method_id' => 'required',
        'individual_entrepreneur_id' => 'required',
    ];

    public function individualEntrepreneur(): BelongsTo
    {
        return $this->belongsTo(IndividualEntrepreneur::class, 'individual_entrepreneur_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
