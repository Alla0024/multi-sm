<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class BonusProgramToStore extends Model
{
    use HasCompositeKey;

    public $table = 'bonus_program_to_stores';

    public $timestamps = false;

    protected $primaryKey = [
        'bonus_program_id',
        'store_id'
    ];

    public $fillable = [
        'bonus_program_id',
        'store_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'store_id' => 'required',
        'bonus_program_id' => 'required',
    ];

    public function bonusProgram(): BelongsTo
    {
        return $this->belongsTo(BonusProgram::class, 'bonus_program_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
