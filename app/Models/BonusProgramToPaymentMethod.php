<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class BonusProgramToPaymentMethod extends Model
{
    use HasCompositeKey;

    public $table = 'bonus_program_to_payments';

    public $timestamps = false;

    protected $primaryKey = [
        'bonus_program_id',
        'payment_id'
    ];

    public $fillable = [
        'bonus_program_id',
        'payment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'payment_id' => 'required',
        'bonus_program_id' => 'required',
    ];

    public function bonusProgram(): BelongsTo
    {
        return $this->belongsTo(BonusProgram::class, 'bonus_program_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment');
    }
}
